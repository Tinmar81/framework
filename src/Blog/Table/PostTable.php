<?php

namespace Blog\Table;

class PostTable
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * paginate the articles
     * @return \stdClass[]
     */
    public function findPaginated(): array
    {
        $posts = $this->pdo
            ->query('SELECT * FROM posts ORDER BY created_at DESC LIMIT 10 ')
            ->fetchAll();

        return $posts;
    }

    /**
     * @param int $id
     * @param string $slug
     * @return \stdClass
     */
    public function find(int $id, string $slug)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM posts WHERE id=:id AND slug=:slug');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        return $stmt->fetch();
    }
}
