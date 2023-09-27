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
    "Log": true,
    "TwitchMessageParser": true,
    "api": "readonly",
    "arrayFilter": true,
    "bestEntries": true,
    "electron": "readonly",
    "formatChatMessage": true,
    "hexToRgbA": true,
    "paginate": true,
    "setGameData": true,
    "setGameWindow": true,
    "setPlayers": true,
    "setQuestionWindow": true,
    "setStore": true
  },
  env: {
    browser: true,
    node: true
  },
  rules: {
    'vue/require-default-prop': 'off',
    'vue/multi-word-component-names': 'off',
    'vue/no-reserved-component-names': 'off'
  }
}
