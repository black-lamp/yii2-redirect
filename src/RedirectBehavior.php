<?php
/**
 * @link https://github.com/black-lamp/yii2-redirect
 * @copyright Copyright (c) 2017 Vladimir Kuprienko
 * @license BSD 3-Clause License
 */

namespace bl\redirect;

use Yii;
use yii\base\Behavior;
use yii\base\Controller;

/**
 * RedirectBehavior is a component for configuration of redirects
 * from controller actions to some routes or previous page
 *
 * Using example
 * ```php
 * public function behaviors() {
 *      return [
 *          'redirect' => [
 *              'class' => \bl\redirect\RedirectBehavior::class,
 *              'actions' => [
 *                  'register' => ['/news'],
 *                  'send-request' => ['/user']
 *              ]
 *           ]
 *      ];
 * }
 * ```
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class RedirectBehavior extends Behavior
{
    /**
     * @var array redirects configuration array
     */
    public $actions = [];


    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
            Controller::EVENT_AFTER_ACTION  => 'afterAction'
        ];
    }

    /**
     * Event handler for configuration a default redirect route
     *
     * @param \yii\base\ActionEvent $event
     */
    public function beforeAction($event)
    {
        $referrer = Yii::$app->getRequest()->getReferrer();

        $url = (!empty($referrer)) ? $referrer : Yii::$app->homeUrl;
        Yii::$app->getUser()->setReturnUrl($url);
    }

    /**
     * Event handler for redirection
     *
     * @param \yii\base\ActionEvent $event
     * @return \yii\web\Response
     */
    public function afterAction($event)
    {
        $action = $event->action;
        if (isset($this->actions[$action->id])) {
            $route = $this->actions[$action->id];
            if (!empty($route)) {
                return $action->controller->redirect($route);
            }

            return $action->controller->goBack();
        }
    }
}