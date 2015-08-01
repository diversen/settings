<?php


use diversen\conf;
use diversen\session;
use diversen\layout;
use diversen\html;
use diversen\lang;
use diversen\http;

class settings_mail {

    public $errors = array();

    public function indexAction() {
        if (!conf::getModuleIni('settings_allow_email')) {
            moduleloader::setStatus(403);
            return;
        }

        if (!session::checkAccessFromModuleIni('settings_allow_edit')) {
            return;
        }

        layout::disableMainModuleMenu();

        $m = new settings_mail();

        if (!empty($_POST)) {
            $_POST = html::specialEncode($_POST);
            $m->validateMethod();
            if (empty($m->errors)) {
                $res = $m->updateMethod();
                if ($res) {
                    $message = lang::translate('settings: action message: mail method updated');
                    http::locationHeader('/settings/mail/index', $message);
                }
            }
        }

        $m->mailFormMethod();
    }

    public function paramsAction() {
        if (!conf::getModuleIni('settings_allow_email')) {
            moduleloader::setStatus(403);
            return;
        }

        if (!session::checkAccessFromModuleIni('settings_allow_edit')) {
            return;
        }

        layout::disableMainModuleMenu();

        $_POST = html::specialEncode($_POST);
        $method = conf::getMainIni('mail_method');

        $m = new settings_mail();

        if ($method == 'smtp') {
            if (isset($_POST['smtp_submit'])) {
                $m->validateSMTP();
                if (empty($m->errors)) {
                    $res = $m->updateSMTP();
                    if ($res) {
                        $message = lang::translate('settings: action message: smtp updated');
                        http::locationHeader('/settings/mail/params', $message);
                    }
                } else {
                    html::errors($m->errors);
                }
            }
            $m->mailFormSMTP();
        }

        if ($method == 'sendmail') {
            if (isset($_POST['sendmail_submit'])) {
                if (empty($m->errors)) {
                    $res = $m->updateSendmail();
                    if ($res) {
                        $message = lang::translate('settings: action message: sendmail updated');
                        http::locationHeader('/settings/mail/params', $message);
                    }
                }
            }
            $m->mailFormSendmail();
        }

        if ($method == 'mail') {
            if (isset($_POST['mail_submit'])) {
                if (empty($m->errors)) {
                    $res = $m->updateMail();
                    if ($res) {
                        $message = lang::translate('settings: action message: smtp updated');
                        http::locationHeader('/settings/mail/params', $message);
                    }
                }
            }
            $m->mailFormMail();
        }
    }

    public function systemAction() {
        if (!conf::getModuleIni('settings_allow_email')) {
            moduleloader::setStatus(403);
            return;
        }

        if (!session::checkAccessFromModuleIni('settings_allow_edit')) {
            return;
        }

        layout::disableMainModuleMenu();

        $m = new settings_mail();
        if (isset($_POST['site_email_submit'])) {
            if (empty($m->errors)) {
                $res = $m->updateSiteEmail();
                if ($res) {
                    $message = lang::translate('settings: action message: site email updated');
                    http::locationHeader('/settings/mail/system', $message);
                }
            }
        }
        $m->mailFormSiteEmail();
    }

    public function validateMethod() {
        $method = @$_POST['mail_method'];
        if ($method != 'smtp' XOR $method != 'sendmail' XOR $method != 'mail') {
            $this->errors[] = lang::translate('settings: error: not a valid mail method');
        }
    }

    public function validateSMTP() {
        if (
                empty($_POST['smtp_params_host']) ||
                empty($_POST['smtp_params_port']) ||
                empty($_POST['smtp_params_username']) ||
                empty($_POST['smtp_params_password']) ||
                empty($_POST['smtp_params_auth'])
        ) {
            $this->errors[] = lang::translate('settings: error: all smtp params needs to be set');
        }
    }

    public function updateMethod() {
        return configdb::set('mail_method', $_POST['mail_method'], 'main');
    }

    public function updateSMTP() {
        $_POST = html::specialDecode($_POST);

        configdb::set('smtp_params_host', $_POST['smtp_params_host'], 'main');
        configdb::set('smtp_params_port', $_POST['smtp_params_port'], 'main');
        configdb::set('smtp_params_username', $_POST['smtp_params_username'], 'main');
        configdb::set('smtp_params_password', $_POST['smtp_params_password'], 'main');
        configdb::set('smtp_params_auth', $_POST['smtp_params_auth'], 'main');

        // we just trust this simple update.
        return 1;
    }

    public function updateSendmail() {
        $_POST = html::specialDecode($_POST);

        configdb::set('sendmail_path', $_POST['sendmail_path'], 'main');
        configdb::set('sendmail_args', $_POST['sendmail_args'], 'main');

        // we just trust this simple update.
        return 1;
    }

    public function updateSiteEmail() {
        $_POST = html::specialDecode($_POST);

        configdb::set('site_email', $_POST['site_email'], 'main');


        // we just trust this simple update.
        return 1;
    }

    public function updateMail() {
        $_POST = html::specialDecode($_POST);

        configdb::set('mail_params', $_POST['mail_params'], 'main');

        // we just trust this simple update.
        return 1;
    }

    public function mailFormMethod() {

        $method = conf::getMainIni('mail_method');

        $f = new html ();
        $f->init(null, 'mail_method_submit');

        $legend = lang::translate('settings: mail method legend');

        $f->formStart('mail_settings_form');
        $f->legend($legend);
        $f->label('mail_method', lang::translate('settings: mail label type'));

        $ary = array(
            array(
                'id' => 'smtp',
                'title' => 'SMTP'
            ),
            array(
                'id' => 'sendmail',
                'title' => 'Sendmail'
            ),
            array(
                'id' => 'mail',
                'title' => 'PHP mail function'
            )
        );

        $f->select('mail_method', $ary, 'title', 'id', $method);

        $f->submit('mail_method_submit', lang::system('submit'));
        $f->formEnd();
        echo $f->getStr();
    }

    public function mailFormSMTP() {
        $values = array(
            'smtp_params_host' => conf::getMainIniAsString('smtp_params_host'),
            'smtp_params_port' => conf::getMainIniAsString('smtp_params_port'),
            'smtp_params_username' => conf::getMainIniAsString('smtp_params_username'),
            'smtp_params_password' => conf::getMainIniAsString('smtp_params_password'),
            'smtp_params_auth' => conf::getMainIniAsString('smtp_params_auth')
        );

        $values = html::specialEncode($values);

        $f = new html();
        $f->init($values, 'smtp_submit');

        $f->formStart('mail_settings_form');


        $legend = lang::translate('settings: mail smtp legend');
        $f->legend($legend);

        $f->label('smtp_params_host', lang::translate('settings: label mail smtp host'));
        $f->text('smtp_params_host');

        $f->label('smtp_params_port', lang::translate('settings: label mail smtp port'));
        $f->text('smtp_params_port');

        $f->label('smtp_params_username', lang::translate('settings: label mail smtp username'));
        $f->text('smtp_params_username');

        $f->label('smtp_params_password', lang::translate('settings: label mail smtp password'));
        $f->text('smtp_params_password');

        $f->label('smtp_params_auth', lang::translate('settings: label mail smtp auth'));
        $f->text('smtp_params_auth');

        $f->submit('smtp_submit', lang::system('submit'));

        $f->formEnd();
        echo $f->getStr();
    }

    public function mailFormSendmail() {
        $values = array(
            'sendmail_path' => conf::getMainIniAsString('sendmail_path'),
            'sendmail_args' => conf::getMainIniAsString('sendmail_args')
        );

        $values = html::specialEncode($values);


        $f = new html();
        $f->init($values, 'sendmail_submit');
        $f->formStart('mail_settings_form');

        $legend = lang::translate('settings: mail smtp legend');
        $f->legend($legend);

        $f->label('sendmail_path', lang::translate('settings: label mail sendmail path'));
        $f->text('sendmail_path');

        $f->label('sendmail_args', lang::translate('settings: label mail sendmail args'));
        $f->text('sendmail_args');

        $f->submit('sendmail_submit', lang::system('submit'));

        $f->formEnd();
        echo $f->getStr();
    }

    public function mailFormMail() {
        $values = array(
            'mail_params' => conf::getMainIniAsString('mail_params'),
        );

        $values = html::specialEncode($values);


        $f = new html();
        $f->init($values, 'mail_submit');
        $f->formStart('mail_settings_form');

        $legend = lang::translate('settings: mail php legend');
        $f->legend($legend);

        $f->label('mail_params', lang::translate('settings: label mail php params'));
        $f->text('mail_params');



        $f->submit('mail_submit', lang::system('submit'));

        $f->formEnd();
        echo $f->getStr();
    }

    public function mailFormSiteEmail() {
        $values = array(
            'site_email' => conf::getMainIniAsString('site_email'),
        );

        $values = html::specialEncode($values);


        $f = new html();
        $f->init($values, 'site_email_submit');
        $f->formStart('mail_settings_form');

        $legend = lang::translate('settings: mail email system legend');
        $f->legend($legend);

        $f->label('site_email', lang::translate('settings: label mail system site email'));
        $f->text('site_email');

        $f->submit('site_email_submit', lang::system('submit'));

        $f->formEnd();
        echo $f->getStr();
    }

}
