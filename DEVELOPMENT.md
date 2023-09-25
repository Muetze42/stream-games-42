# Stream Games 42

## Notice

You need access to the https://github.com/Muetze42/stream-games-42-src repository.

## Development

### Project Setup

Copy `env.example.json` to `env.json` and set data in `env.json`.

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

Copy font files to `/src/renderer/public/fonts/<font name>/*.woff(2)` and run

```bash
php streamgames update:fonts
```

### Commands

#### Create Faked Chat Responses

The default locale is `de_DE`.

```bash
php streamgames faker:chat-responses
```
