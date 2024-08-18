<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateModelFromMigration extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:model-from-migration {migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a model based on an existing migration file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $migrationName = $this->argument('migration');
        $migrationPath = database_path("migrations/{$migrationName}.php");

        if (!File::exists($migrationPath)) {
            $this->error("Migration file not found!");
            return;
        }

        $migrationContent = File::get($migrationPath);
        preg_match('/Schema::create\(\'(\w+)\',/', $migrationContent, $matches);
        $tableName = $matches[1];

        preg_match_all('/\$table->\w+\(\'(\w+)\'/', $migrationContent, $matches);
        $columns = $matches[1];

        $modelName = ucfirst(Str::singular($tableName));
        $modelPath = app_path("Models/{$modelName}.php");

        $fillable = implode("', '", $columns);

        $modelTemplate = "<?php

        namespace App\Models;

        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\Model;

        class {$modelName} extends Model
        {
            use HasFactory;

            protected \$fillable = ['{$fillable}'];
        }";

        File::put($modelPath, $modelTemplate);

        $this->info("Model {$modelName} created successfully!");
    }
}
