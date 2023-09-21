# Stream Games 42

An [Electron application](https://www.electronjs.org/) with [Vue](https://vuejs.org/)
and [Tailwind CSS](https://tailwindcss.com/)

## Notice

You need access to the https://github.com/Muetze42/stream-games-42-src repository.

## Development

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

### Commands

#### Create Faked Chat Responses

The default locale is `de_DE`.

```bash
php streamgames faker:chat-responses
```
