<?php

class UserFile extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    public $id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $user_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $fileName;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $fileDir;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("test");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'userFile';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Userfile[]|Userfile
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Userfile
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
