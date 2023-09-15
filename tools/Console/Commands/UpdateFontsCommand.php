<?php

namespace NormanHuth\StreamGames42\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class UpdateFontsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:fonts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update resource files fonts.';

    /**
     * The Filesystem instance
     *
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    protected string $stub;

    protected array $contents = [
        '_fonts.scss' => '',
        'font-family.js' => "module.exports = [\n  'font-sans',\n  'font-serif',\n  'font-mono'",
        'fonts.js' => '',
        'fonts.json' => [
            'font-sans' => 'UI Sans Serif',
            'font-serif' => 'UI Serif',
            'font-mono' => 'UI Monospace'
        ],
    ];

    /**
     * Execute the console command.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle(): void
    {
        $this->filesystem = new Filesystem();
        $directory = realpath(__DIR__ . '/../../../src/renderer/public/fonts');
        $directories = $this->filesystem->directories($directory);
        $this->stub = $this->filesystem->get(__DIR__ . '/../../../stubs/font-face.stub');

        foreach ($directories as $directory) {
            $this->handleDirectory($directory);
        }

        file_put_contents(
            __DIR__ . '/../../../src/renderer/src/assets/scss/_fonts.scss',
            trim($this->contents['_fonts.scss']) . "\n"
        );
        file_put_contents(
            __DIR__ . '/../../../src/renderer/resources/fonts.js',
            "export default {\n" . $this->contents['fonts.js'] . "\n}\n"
        );
        file_put_contents(
            __DIR__ . '/../../../src/renderer/src/data/fonts.json',
            jsonPrettyEncode($this->contents['fonts.json']) . "\n"
        );
        file_put_contents(
            __DIR__ . '/../../../src/renderer/resources/used/font-family.js',
            $this->contents['font-family.js'] . "\n]\n"
        );
    }

    /**
     * @param string $directory
     *
     * @return void
     */
    protected function handleDirectory(string $directory): void
    {
        $family = basename($directory);
        $slug = Str::slug($family);
        $this->info('Handle „' . $family . '“ font');
        $files = $this->filesystem->files($directory);

        foreach ($files as $file) {
            if ($this->filesystem->extension($file) != 'woff' && $this->filesystem->extension($file) != 'woff2') {
                $this->filesystem->delete($file);
            }
        }

        if (!count($files)) {
            return;
        }

        $file = $files[0];

        $fileName = $this->filesystem->name($file);
        $type = explode('-', $fileName);
        $type = end($type);
        $style = str_contains($type, 'italic') ? 'italic' : 'normal';
        $weight = preg_replace('/\D/', '', $type);
        if (empty($weight)) {
            $weight = 400;
        }
        $woff2 = $directory . '/' . $fileName . '.woff2';
        $woff = $directory . '/' . $fileName . '.woff';

        $urls = '';
        if (file_exists($woff2)) {
            $urls .= 'url(\'' . '/fonts/' . $family . '/' . $fileName . '.woff2\') format(\'woff2\')';
        }
        if (file_exists($woff) && file_exists($woff2)) {
            $urls .= ",\n       ";
        }
        if (file_exists($woff)) {
            $urls .= 'url(\'' . '/fonts/' . $family . '/' . $fileName . '.woff\') format(\'woff\')';
        }

        if (!$urls) {
            return;
        }

        $replace = [
            '{comment}' => '/* ' . $family . ': ' . $fileName . ' */',
            '{family}' => $family,
            '{style}' => $style,
            '{weight}' => $weight,
            '{urls}' => $urls,
        ];
        $this->contents['_fonts.scss'] .= str_replace(array_keys($replace), array_values($replace), $this->stub);

        if ($this->contents['fonts.js']) {
            $this->contents['fonts.js'] .= ",\n";
        }

        $this->contents['font-family.js'] .= ",\n  'font-" . $slug . '\'';
        $this->contents['fonts.json']['font-' . $slug] = $family;

        $key = str_contains($slug, '-') ? '\'' . $slug . '\'' : $slug;
        $this->contents['fonts.js'] .= '  ' . $key . ': [\'' . $family . '\']';
    }
}
