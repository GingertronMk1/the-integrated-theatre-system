module.exports = {
    env: {
        browser: true,
    },
    extends: [
        "plugin:vue/vue3-recommended",
        "plugin:prettier/recommended"
    ],
    parserOptions: {
        ecmaVersion: 12,
        sourceType: "module"
    },
    ignorePatterns: [
        "node_modules/**/*",
        "vendor/**/*",
        "dist/**/*"
    ],
    globals: {
        route: "readonly"
    },
    rules: {
        "vue/multi-word-component-names": "off"
    }
}
