/* eslint-env node */
require('@rushstack/eslint-patch/modern-module-resolution')

module.exports = {
  extends: [
    'eslint:recommended',
    'plugin:vue/vue3-recommended',
    '@electron-toolkit',
    '@vue/eslint-config-prettier'
  ],
  globals: {
    "electron": "readonly",
    "api": "readonly",
    "formatChatMessage": "readonly",
    "TwitchMessageParser": "readonly",
    "arrayFilter": "readonly",
    "bestEntries": "readonly"
  },
  rules: {
    'vue/require-default-prop': 'off',
    'vue/multi-word-component-names': 'off',
    'vue/no-reserved-component-names': 'off'
  }
}
