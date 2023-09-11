<?php
declare(strict_types=1);

namespace App\Command;

use Bake\Utility\TableScanner;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Inflector;
use Cake\View\Exception\MissingTemplateException;
use RuntimeException;

    class VueTemplateCommand extends \Bake\Command\TemplateCommand
{

    public function execute(Arguments $args, ConsoleIo $io): ?int
    {
        $io->out("\n" . "executing Command vue_template ");

        $this->extractCommonProperties($args);
        $name = $args->getArgument('name') ?? '';
        $name = $this->_getName($name);

        if (empty($name)) {
            $io->out('Possible tables to bake view templates for based on your current database:');
            /** @var \Cake\Database\Connection $connection */
            $connection = ConnectionManager::get($this->connection);
            $scanner = new TableScanner($connection);
            foreach ($scanner->listUnskipped() as $table) {
                $io->out('- ' . $this->_camelize($table));
            }

            return static::CODE_SUCCESS;
        }
        $template = $args->getArgument('template');
        $action = $args->getArgument('action');

        $controller = $args->getOption('controller');
        $this->controller($args, $name, $controller);
        $this->model($name);

        if ($template && $action === null) {
            $action = $template;
        }
        if ($template) {
            $this->bake($args, $io, $template, true, $action);

            return static::CODE_SUCCESS;
        }

        $vars = $this->_loadController($io);
        $methods = $this->_methodsToBake();

        foreach ($methods as $method) {
            try {
                $content = $this->getContent($args, $io, $method, $vars);
                $this->bake($args, $io, $method, $content);
            } catch (MissingTemplateException $e) {
                $io->verbose($e->getMessage());
            } catch (RuntimeException $e) {
                $io->error($e->getMessage());
            }
        }

        return static::CODE_SUCCESS;
    }

    /**
     * Assembles and writes bakes the view file.
     *
     * @param \Cake\Console\Arguments $args CLI arguments
     * @param \Cake\Console\ConsoleIo $io Console io
     * @param string $template Template file to use.
     * @param string|true $content Content to write.
     * @param ?string $outputFile The output file to create. If null will use `$template`
     * @return void
     */
    public function bake(
        Arguments $args,
        ConsoleIo $io,
        string $template,
                  $content = '',
        ?string $outputFile = null
    ): void {
        if ($outputFile === null) {
            $outputFile = $template;
        }
        if ($content === true) {
            $content = $this->getContent($args, $io, $template);
        }
        if (empty($content)) {
            // phpcs:ignore Generic.Files.LineLength
            $io->err("<warning>No generated content for '{$template}.{$this->ext}', not generating template.</warning>");

            return;
        }
        $path = $this->getTemplatePath($args);
        $filename = $path . ucfirst(Inflector::underscore($outputFile)) . '.' . 'vue';

        $io->out("\n" . sprintf('Baking `%s` view template file...', $outputFile), 1, ConsoleIo::NORMAL);
        $io->createFile($filename, $content, $this->force);
    }

    /**
     * Get the path base for view templates.
     *
     * @param \Cake\Console\Arguments $args The arguments
     * @param string|null $container Unused.
     * @return string
     */
    public function getTemplatePath(Arguments $args, ?string $container = null): string
    {
        $path = ROOT . DS . 'resources' . DS . 'js' . DS. 'Components' . DS;
        $path .= $this->controllerName . DS;

        return $path;
    }

}
