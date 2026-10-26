"use strict";

const assert = require("node:assert/strict");
const fs = require("node:fs");
const path = require("node:path");
const vm = require("node:vm");

const assignmentPattern = /this\.containerEventName\s*=\s*this\.containerId\s*(?:\.replace\(\/(?:\\.|[^/\\])*\/g,\s*(?:"(?:\\.|[^"\\])*"|'(?:\\.|[^'\\])*')\)\s*){2}/;
vm.runInNewContext(`
    for (const length of [64, 1024, 16384]) {
        const input = "this.containerEventName=this.containerId.replace(/" + "\\\\.".repeat(length);
        assert.equal(pattern.test(input), false);
    }
`, { assert, pattern: assignmentPattern }, { timeout: 1000 });

for (const file of ["select2.2.js", "select2.2.min.js"]) {
    const source = fs.readFileSync(path.join(__dirname, "../inc/external/wpmu-lib/js", file), "utf8");
    const assignment = source.match(assignmentPattern);
    assert.ok(assignment, file + ": event namespace assignment exists");
    const script = new vm.Script(assignment[0]);
    const cases = [
        ["s2id_example", "s2id_example"],
        ["s2id_a.b", "s2id_a_b"],
        ["s2id_a\\b", "s2id_a\\\\b"],
        ["s2id_a\\", "s2id_a\\\\"],
        ["s2id_a\\\\b", "s2id_a\\\\\\\\b"],
        ["s2id_a\\[b]", "s2id_a\\\\\\[b\\]"],
        ["s2id_a\\.b", "s2id_a\\\\_b"]
    ];
    for (const character of ";&,-+*~':\"!^#$%@[]()=>|") {
        cases.push(["s2id_a" + character + "b", "s2id_a\\" + character + "b"]);
        cases.push(["s2id_a\\" + character + "b", "s2id_a\\\\\\" + character + "b"]);
    }
    for (const [input, expected] of cases) {
        const context = vm.createContext({ containerId: input });
        script.runInContext(context);
        assert.equal(context.containerEventName, expected, file + ": " + JSON.stringify(input));
        assert.equal(context.containerId, input);
        const namespace = new RegExp("^" + context.containerEventName + "$");
        assert.ok(namespace.test(input.replace(/\./g, "_")), file + ": namespace matches literally");
    }
    console.log(file + ": backslash, punctuation and literal namespace matching passed");
}
