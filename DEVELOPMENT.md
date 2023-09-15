# Stream Games 42

An [Electron application](https://www.electronjs.org/) with [Vue](https://vuejs.org/)
and [Tailwind CSS](https://tailwindcss.com/)

## Notice

You need access to the https://github.com/Muetze42/stream-games-42-src repository.

## Development

## Recommended IDE Setup

- [ESLint](https://marketplace.visualstudio.com/items?itemName=dbaeumer.vscode-eslint) + [Prettier](https://marketplace.visualstudio.com/items?itemName=esbenp.prettier-vscode) + [Volar](https://marketplace.visualstudio.com/items?itemName=Vue.volar)

### Project Setup

## Install

```bash
pnpm install
```

### Development

```bash
pnpm dev
```

### Build

#### For Windows

```bash
pnpm build:win
```

#### For macOS

```bash
pnpm build:mac
```

#### For Linux

```bash
pnpm build:linux
```

### Update Fonts

Copy font files to `/src/renderer/public/fonts/<font name>/*.woff` and run

```bash
php streamgames update:fonts
```
