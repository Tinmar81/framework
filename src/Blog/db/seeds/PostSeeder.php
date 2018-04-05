<?php


use Phinx\Seed\AbstractSeed;

class PostSeeder extends AbstractSeed
{

    public function run()
    {
        $data=[];
        $faker = \Faker\Factory::create('fr_FR');

        for ($i=0; $i<100; $i++) {
            $date = $faker->unixTime('now');

            $data[] = [
                'name' => $faker->sentence('5'),
                'slug' => $faker->slug,
                'content' => $faker->text(3000),
                'created_at' => date('Y-m-d H:i:s', $date),
                'updated_at' => date('Y-m-d H:i:s', $date)
            ];
        }

        $this->table('posts')
            ->insert($data)
            ->save();
    }
}
