<?php
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Validation;
use Phalcon\Events\Event;


class User extends \Phalcon\Mvc\Model

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
     * @Column(type="integer", length=2, nullable=true)
     */
    public $sex;

    /**
     *
     * @var string
     * @Column(type="string", length=15, nullable=true)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(type="string", length=15, nullable=true)
     */
    public $username;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $password;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $email;



    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        //$this->setSchema("test");

        $eventsManager = new EventsManager();

        // Attach an anonymous function as a listener for "model" events
        $eventsManager->attach(
            "model:beforeSave",
            function (Event $event, $robot) {
                if ($robot->name === "月光") {
                    echo "月光 Doo isn't a robot!";
                    return false;
                }

                return true;
            }
        );

        // Attach the events manager to the event
        $this->setEventsManager($eventsManager);
    }




    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]|User
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }






}
