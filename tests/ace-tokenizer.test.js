"use strict";

const assert = require("node:assert/strict");
const fs = require("node:fs");
const path = require("node:path");
const vm = require("node:vm");

for (const file of ["ace.js", "ace.min.js"]) {
    const source = fs.readFileSync(path.join(__dirname, "../js", file), "utf8");
    const start = source.indexOf('ace.define("ace/tokenizer"');
    const end = source.indexOf('ace.define(', start + 1);
    assert.notEqual(start, -1, file + ": tokenizer module exists");
    assert.notEqual(end, -1, file + ": next module exists");

    const context = vm.createContext({
        assert,
        ace: {
            define: function(name, dependencies, factory) {
                assert.equal(name, "ace/tokenizer");
                const exports = {};
                factory(null, exports, { exports });
                this.Tokenizer = exports.Tokenizer;
            }
        }
    });
    vm.runInContext(source.slice(start, end).replace(/,\s*$/, ";"), context);
    function testTokenizer() {
        const tokenizer = new ace.Tokenizer({ start: [] });
        const cases = [
            ["(foo)(bar)", "(?:foo)(?:bar)"],
            ["(?:foo)(?=bar)(?!baz)(qux)", "(?:foo)(?=bar)(?!baz)(?:qux)"],
            [String.raw`\(foo\)(bar)`, String.raw`\(foo\)(?:bar)`],
            ["[()](foo)", "[()](?:foo)"],
            [String.raw`[\]()](foo)`, String.raw`[\]()](?:foo)`],
            [String.raw`[\\](foo)`, String.raw`[\\](?:foo)`],
            ["[abc(foo)", "[abc(?:foo)"]
        ];
        for (const [input, expected] of cases) {
            assert.equal(tokenizer.removeCapturingGroups(input), expected);
        }

        const split = new ace.Tokenizer({
            start: [{ regex: "(foo)(bar)", token: ["keyword", "string"] }]
        });
        assert.equal(JSON.stringify(split.getLineTokens("foobar", "start")), JSON.stringify({
            tokens: [{ type: "keyword", value: "foo" }, { type: "string", value: "bar" }],
            state: "start"
        }));

        for (const length of [64, 1024, 16384]) {
            const input = "[" + "\\".repeat(length) + "(foo)";
            assert.equal(tokenizer.removeCapturingGroups(input),
                "[" + "\\".repeat(length) + "(?:foo)");
        }
    }
    vm.runInContext("(" + testTokenizer.toString() + ")()", context, { timeout: 1000 });
    console.log(file + ": tokenizer regressions passed (including malformed input within 1s)");
}
