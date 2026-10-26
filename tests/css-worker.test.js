"use strict";

const assert = require("node:assert/strict");
const fs = require("node:fs");
const path = require("node:path");
const vm = require("node:vm");

for (const file of ["worker-css.js", "worker-css.min.js"]) {
    const messages = [];
    const context = vm.createContext({
        assert,
        postMessage: message => messages.push(message),
        setTimeout: () => 1,
        clearTimeout: () => {},
        importScripts: () => { throw new Error("Unexpected external module load"); }
    });
    vm.runInContext(fs.readFileSync(path.join(__dirname, "../js", file), "utf8"), context);
    const send = message => context.onmessage({ data: message });
    const command = (name, args) => send({ command: name, args });

    assert.equal(Object.getPrototypeOf(context.require.modules), null);
    for (const id of ["__proto__", "constructor", "toString", "hasOwnProperty",
        "missing", "https://example.invalid/worker", "//example.invalid/worker"]) {
        assert.throws(() => context.require(id), /Unknown worker module/);
    }
    for (const id of [42, {}, ["ace/lib/oop"]]) {
        assert.throws(() => context.require(id), /accepts only/);
    }
    vm.runInContext(`
        Object.prototype.inheritedWorkerModule = {
            factory: function() { throw new Error("Inherited factory executed"); }
        };
        try {
            assert.throws(function() {
                require("inheritedWorkerModule");
            }, /Unknown worker module/);
            assert.equal(Object.prototype.inheritedWorkerModule.initialized, undefined);
            assert.equal(Object.prototype.inheritedWorkerModule.exports, undefined);
            assert.equal(Object.prototype.hasOwnProperty.call(Object.prototype, "initialized"), false);
            assert.equal(Object.prototype.hasOwnProperty.call(Object.prototype, "exports"), false);
        } finally {
            delete Object.prototype.inheritedWorkerModule;
        }
    `, context);
    for (const id of Object.keys(context.require.modules)) {
        assert.ok(context.require(id), file + ": bundled module loads: " + id);
    }
    assert.equal(context.require("ace/mode/css_worker", "../lib/oop"), context.require("ace/lib/oop"));

    assert.throws(() => command("setValue", [""]), /not initialized/);
    for (const [module, classname] of [
        ["ace/mode/css_worker", "constructor"],
        ["ace/mode/css_worker", "__proto__"],
        ["ace/worker/mirror", "Worker"],
        ["https://example.invalid/worker", "Worker"]
    ]) {
        assert.throws(() => send({ init: true, module, classname }), /Unknown worker module or class/);
        assert.equal(context.main, null);
    }
    send({
        init: true,
        module: "ace/mode/css_worker",
        classname: "Worker",
        tlns: { ace: "https://example.invalid" }
    });

    for (const name of ["constructor", "toString", "hasOwnProperty", "__defineGetter__",
        "__proto__", "doc", "sender", "nonexistent", ["setValue"]]) {
        assert.throws(() => command(name, []), /Unknown worker command/);
    }
    assert.throws(() => command("setValue", { 0: "invalid", length: 1 }), /must be an array/);
    command("setTimeout", [10]);
    assert.equal(context.main.$timeout, 10);
    command("setValue", ["a { color: red; }"]);
    command("getValue", [42]);
    assert.equal(messages.at(-1).type, "call");
    assert.equal(messages.at(-1).id, 42);
    assert.equal(messages.at(-1).data, "a { color: red; }");
    command("setInfoRules", ["ids"]);
    assert.equal(context.main.infoRules.ids, 1);
    command("setDisabledRules", ["ids"]);
    assert.equal(context.main.ruleset.ids, undefined);
    command("isPending");
    command("onUpdate");
    assert.equal(messages.at(-1).name, "csslint");
    send({
        event: "change",
        data: { data: [{
            action: "insertText",
            range: { start: { row: 0, column: 0 }, end: { row: 0, column: 2 } },
            text: "/*"
        }] }
    });
    command("getValue", [43]);
    assert.equal(messages.at(-1).data, "/*a { color: red; }");
    console.log(file + ": module isolation, bundled dependencies, command validation, CSS linting and changes passed");
}
