<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_view_count`.
 */
class m170314_145237_create_article_view_count_table extends Migration
{
    /**
     * @var string
     */
    public $tableName = 'article_view_count';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer()->notNull(),
            'viewer_id' => $this->integer(),
            'count' => $this->integer()->defaultValue(0),
        ]);

        $this->createIndex(
            "idx-{$this->tableName}-article_id",
            $this->tableName,
            'article_id'
        );

        $this->createIndex(
            "idx-{$this->tableName}-viewer_id",
            $this->tableName,
            'viewer_id'
        );

        $this->addForeignKey("fk-{$this->tableName}-article_id", $this->tableName,
            'article_id', 'article', 'id', 'CASCADE', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey("fk-{$this->tableName}-article_id", $this->tableName);

        $this->dropIndex("idx-{$this->tableName}-article_id", $this->tableName);
        $this->dropIndex("idx-{$this->tableName}-viewer_id", $this->tableName);

        $this->dropTable($this->tableName);
    }
}
