<?php

declare(strict_types=1);

use Adeliom\EasyMediaBundle\Controller\MediaController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $routes->add('media.index', '/easymedia/medias/')
        ->controller([MediaController::class, 'index'])
        ->methods(['GET'])
    ;
    $routes->add('media.browse', '/easymedia/medias/browse')
        ->controller([MediaController::class, 'browse'])
        ->methods(['GET'])
    ;

    $routes->add('media.upload', '/easymedia/medias/upload')
        ->controller([MediaController::class, 'upload'])
        ->methods(['POST'])
    ;
    $routes->add('media.uploadCropped', '/easymedia/medias/upload-cropped')
        ->controller([MediaController::class, 'uploadEditedImage'])
        ->methods(['POST'])
    ;
    $routes->add('media.uploadLink', '/easymedia/medias/upload-link')
        ->controller([MediaController::class, 'uploadLink'])
        ->methods(['POST'])
    ;

    $routes->add('media.get_files', '/easymedia/medias/get-files')
        ->controller([MediaController::class, 'getFiles'])
        ->methods(['POST'])
    ;
    $routes->add('media.get_file_info', '/easymedia/medias/get-file-info')
        ->controller([MediaController::class, 'getItemInfos'])
        ->methods(['POST'])
    ;
    $routes->add('media.new_folder', '/easymedia/medias/create-new-folder')
        ->controller([MediaController::class, 'createNewFolder'])
        ->methods(['POST'])
    ;
    $routes->add('media.delete_file', '/easymedia/medias/delete-file')
        ->controller([MediaController::class, 'deleteItem'])
        ->methods(['POST'])
    ;
    $routes->add('media.move_file', '/easymedia/medias/move-file')
        ->controller([MediaController::class, 'moveItem'])
        ->methods(['POST'])
    ;
    $routes->add('media.rename_file', '/easymedia/medias/rename-file')
        ->controller([MediaController::class, 'renameItem'])
        ->methods(['POST'])
    ;
    $routes->add('media.edit_metas_file', '/easymedia/medias/edit-metas-file')
        ->controller([MediaController::class, 'editMetasItem'])
        ->methods(['POST'])
    ;
    $routes->add('media.generate_alt_file', '/easymedia/medias/generate-alt-file')
        ->controller([MediaController::class, 'generateAltItem'])
        ->methods(['POST'])
    ;
    $routes->add('media.generate_alt_group', '/easymedia/medias/generate-alt-group')
        ->controller([MediaController::class, 'generateAltGroup'])
        ->methods(['POST'])
    ;
    $routes->add('media.generate_all_alt', '/easymedia/medias/generate-all-alt')
        ->controller([MediaController::class, 'generateAllAlt'])
        ->methods(['POST'])
    ;

    $routes->add('media.global_search', '/easymedia/medias/global-search')
        ->controller([MediaController::class, 'globalSearch'])
        ->methods(['GET'])
    ;

    $routes->add('media.folder_download', '/easymedia/medias/folder-download')
        ->controller([MediaController::class, 'downloadFolder'])
        ->methods(['POST'])
    ;
    $routes->add('media.files_download', '/easymedia/medias/files-download')
        ->controller([MediaController::class, 'downloadFiles'])
        ->methods(['POST'])
    ;
};
