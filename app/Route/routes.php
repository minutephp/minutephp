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