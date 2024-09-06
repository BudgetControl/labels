<?php

use Budgetcontrol\Library\Model\Debit;
use Budgetcontrol\Library\Model\Label;
use Budgetcontrol\Library\Model\Payee;
use Budgetcontrol\Seeds\Resources\Seed;
use Phinx\Seed\AbstractSeed;
use Ramsey\Uuid\Uuid;

class MainSeeds extends AbstractSeed
{

    public function run(): void
    {
        $seeds = new Seed();
        $seeds->runAllSeeds();

        // create list of payees
        $labels = [
            [
                'name' => 'JohnDoe',
            ],
        ];

        foreach ($labels as $value) {

            $db = new Label();
            $db->uuid = 'bea004bc-d322-4f4b-9aae-5e8a7c8651fb';
            $db->name = strtolower($value['name']);
            $db->color =  '#' . substr(md5((string) rand(0, 999)), 0, 6);
            $db->workspace_id = 1;
            $db->save();
        }
    }
}
