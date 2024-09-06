<?php
/**
 *  application apps
 */

 $app->get('/{wsid}/list', \Budgetcontrol\Label\Controller\LabelController::class . ':list');
 $app->get('/{wsid}/{label_id}', \Budgetcontrol\Label\Controller\LabelController::class . ':show');
 $app->post('/{wsid}/insert', \Budgetcontrol\Label\Controller\LabelController::class . ':insert');
 $app->put('/{wsid}/{label_id}', \Budgetcontrol\Label\Controller\LabelController::class . ':update');
 $app->patch('/{wsid}/{label_id}', \Budgetcontrol\Label\Controller\LabelController::class . ':patch');
 $app->delete('/{wsid}/{label_id}', \Budgetcontrol\Label\Controller\LabelController::class . ':delete');

 $app->get('/monitor', \Budgetcontrol\Label\Controller\LabelController::class . ':monitor');
