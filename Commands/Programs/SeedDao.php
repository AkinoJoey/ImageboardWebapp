<?php

namespace Commands\Programs;

use Commands\AbstractCommand;

class SeedDao extends AbstractCommand
{
    protected static ?string $alias = 'seed-dao';

    public static function getArguments(): array
    {
        return [];
    }

    public function execute(): int
    {
        $this->runAllSeeds();
        return 0;
    }

    function runAllSeeds(): void
    {
        $directoryPath = __DIR__ . '/../../Database/SeedsDao';

        // $files = scandir($directoryPath);
        $files = ['ThreadsDaoSeeder.php', 'RepliesDaoSeeder'];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                // ファイル名からクラス名を抽出します。
                $className = 'Database\SeedsDao\\' . pathinfo($file, PATHINFO_FILENAME);

                // シードファイルをインクルードします。
                include_once $directoryPath . '/' . $file;

                // 作成するデータ数は50
                if (class_exists($className)) {
                    for ($i = 0; $i < 50; $i++) {
                        $seeder = new $className();
                        $seeder->seed();
                    }
                } else throw new \Exception("$className does not exist.");
            }
        }
    }
}
