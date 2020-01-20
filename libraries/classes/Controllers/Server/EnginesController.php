<?php
/**
 * Holds the PhpMyAdmin\Controllers\Server\EnginesController
 */
declare(strict_types=1);

namespace PhpMyAdmin\Controllers\Server;

use PhpMyAdmin\Common;
use PhpMyAdmin\Controllers\AbstractController;
use PhpMyAdmin\StorageEngine;

/**
 * Handles viewing storage engine details
 */
class EnginesController extends AbstractController
{
    /**
     * Index action
     *
     * @return string
     */
    public function index(): string
    {
        Common::server();

        return $this->template->render('server/engines/index', [
            'engines' => StorageEngine::getStorageEngines(),
        ]);
    }

    /**
     * Displays details about a given Storage Engine
     *
     * @param array $params Request params
     *
     * @return string
     */
    public function show(array $params): string
    {
        Common::server();

        $page = $params['page'] ?? '';

        $engine = [];
        if (StorageEngine::isValid($params['engine'])) {
            $storageEngine = StorageEngine::getEngine($params['engine']);
            $engine = [
                'engine' => $params['engine'],
                'title' => $storageEngine->getTitle(),
                'help_page' => $storageEngine->getMysqlHelpPage(),
                'comment' => $storageEngine->getComment(),
                'info_pages' => $storageEngine->getInfoPages(),
                'support' => $storageEngine->getSupportInformationMessage(),
                'variables' => $storageEngine->getHtmlVariables(),
                'page' => ! empty($page) ? $storageEngine->getPage($page) : '',
            ];
        }

        return $this->template->render('server/engines/show', [
            'engine' => $engine,
            'page' => $page,
        ]);
    }
}
