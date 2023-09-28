<?php

namespace NormanHuth\StreamGames42\Console\Commands;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FakerChatResponses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faker:chat-responses {--locale=de_DE}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crate Fake chat responses and save as JSON file';

    /**
     * The number of users to generate.
     *
     * @var int
     */
    protected int $userCount = 2;

    /**
     * The number of states to add for each user.
     *
     * @var int
     */
    protected int $stateCount = 1;

    /**
     * The number of cities to add for each user.
     *
     * @var int
     */
    protected int $cityCount = 1;

    /**
     * The Faker instance.
     *
     * @var \Faker\Generator|\Faker\Provider\de_DE\Address
     */
    protected mixed $faker;

    /**
     * The data array.
     *
     * @var array
     */
    protected array $data = [
        'wordsAll' => [],
        'userWords' => []
    ];

    /**
     * The generated users.
     *
     * @var array
     */
    protected array $users = [];

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->faker = Factory::create($this->option('locale'));

        $this->createUsers();
        $this->addWords();

        $array = $this->data['wordsAll'];
        arsort($array);
        $this->data['wordsAll'] = $array;

        file_put_contents(
            __DIR__ . '/../../data/chat-responses.json',
            json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        );
    }

    /**
     * @return void
     */
    protected function addWords(): void
    {
        foreach ($this->users as $user) {
            for ($i = 1; $i <= $this->stateCount; $i++) {
                $this->addWord($user, $this->faker->state());
            }
            for ($i = 1; $i <= $this->cityCount; $i++) {
                $this->addWord($user, $this->faker->city());
            }
        }
    }

    /**
     * @param string $user
     * @param string $word
     *
     * @return void
     */
    protected function addWord(string $user, string $word): void
    {
        $word = Str::upper($word);
        if (!in_array($word, data_get($this->data, 'userWords.' . $user, []))) {
            $count = data_get($this->data, 'wordsAll.' . $word, 0);
            $this->data['wordsAll'][$word] = $count + 1;
            $this->data['userWords'][$user][] = $word;
        }
    }

    /**
     * @return void
     */
    protected function createUsers(): void
    {
        for ($i = 1; $i <= $this->userCount; $i++) {
            $this->users[] = $this->faker->domainWord();
        }
    }
}
