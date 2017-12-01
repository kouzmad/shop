<?php

use yii\db\Migration;

/**
 * Class m171126_094705_create_email_confirmation_fields
 */
class m171126_094705_create_email_confirmation_fields extends Migration
{



    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%user}}', 'email_confirm_token', $this->string()->unique()->after('email'));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'email_confirm_token');
    }

}
