<?php

/** @var Router $router */
use Minute\Model\Permission;
use Minute\Routing\Router;

$router->get('/members/wizard/{project_id}', null, true, 'm_projects[project_id][1] as projects')
       ->setDefault('project_id', 0);
$router->post('/members/wizard/{project_id}', null, 'admin', 'm_projects as projects')
       ->setAllPermissions('projects', Permission::SAME_USER)->setDefault('project_id', 0);

$router->get('/members/wizard/step/{step}', 'Members/Wizard@step', true)
       ->setDefault('_noView', true);

$router->get('/members/data/styles', 'Members/Data/Styles', true, 'styles[99]')
       ->setReadPermission('styles', Permission::EVERYONE)->setDefault('styles', '*')
       ->setDefault('_noView', true);
$router->get('/members/data/resources', 'Members/Data/Resources', true)
       ->setDefault('_noView', true);

$router->post('/members/queue-video/{project_id}', 'Members/QueueVideo', true)
       ->setDefault('_noView', true);

$router->get('/test/{project_id}', 'Test', false, 'm_projects[project_id] as project');

$router->get('/members/project/preview/{project_id}', 'Members/ProjectPreview.php', true)
       ->setDefault('_noView', true);

$router->get('/members/projects/data/{project_id}', 'Members/ProjectData.php', false, 'm_projects[project_id] as projects')
       ->setReadPermission('projects', Permission::EVERYONE)->setDefault('_noView', true);