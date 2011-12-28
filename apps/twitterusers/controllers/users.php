<?php
require_once('apps/twitterusers/deps/twitter-async/EpiCurl.php');
require_once('apps/twitterusers/deps/twitter-async/EpiOAuth.php');
require_once('apps/twitterusers/deps/twitter-async/EpiTwitter.php');

require_once('apps/default/controllers/abstract.php');
class UsersController extends AbstractController {

    public function init() {
        parent::init();
        switch ($this->path->getAction()) {
            case "login":
            case "authed":
                if ($this->user->isAccount()) {
                    // go away
                    $this->redirect("/", "You're already logged in!");
                    throw new CoreException("Already logged in");
                }
                break;
            case "logout":
            case "my_questions":
                if ($this->user->isAccount() === false) {
                    $this->redirect("/");
                    throw new CoreException("Not Authed");
                }
                break;
            default:
                break;
        }
    }

    public function login() {
        try {
            $twitterObj = new EpiTwitter(Settings::getValue('twitter.consumer_key'), Settings::getValue('twitter.consumer_secret'));

            Log::debug('Redirecting to twitter auth URL');

            $authedUrl = $this->request->getBaseHref()."authed";
            if ($this->request->getVar('target') !== null) {
                $authedUrl .= "?target=".urlencode($this->request->getVar('target'));
            }

            return $this->redirect($twitterObj->getAuthenticateUrl(null, array(
                'oauth_callback' => $authedUrl,
            )));
        } catch (Exception $e) {
            // uh oh
            Log::debug('could not get oauth URL: '.$e->getMessage());
            return $this->redirect('/', 'Uh oh! Couldn\'t get twitter auth URL');
        }
    }

    public function logout() {
        $this->user->logout();
        return $this->redirect(array(
            "app" => "bettershared",
            "controller" => "Bettershared",
            "action" => "index",
        ), "Bye! Come back soon!");
    }

    public function authed() {
        $twitterObj = new EpiTwitter(Settings::getValue('twitter.consumer_key'), Settings::getValue('twitter.consumer_secret'));

        try {
            $twitterObj->setToken($this->request->getVar('oauth_token'));
            $token = $twitterObj->getAccessToken();
            $twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);

            $details = $twitterObj->get_accountVerify_credentials();
        } catch (Exception $e) {
            return $this->redirect(array(
                "app" => "default",
                "controller" => "Default",
                "action" => "index",
            ), "Oops! There was a problem logging into Twitter. Please try again");
        }

        $user = Table::factory('Users')->findByTwitterId($details->id);
        if ($user === false) {
            if ($this->user->isGuest()) {
                // right. if this user has a *guest* account, we're okay to convert them to a proper user row
                // since they haven't ever interacted with the site as a full user (we have no DB record of them)
                Log::debug('converting guest ID ['.$this->user->getId().'] to full account for username ['.$details->screen_name.']');
                $user = $this->user;
            } else {
                // we know the user isn't a full account (they wouldn't get here), so they're brand new
                Log::debug('creating new account for username ['.$details->screen_name.']');
                $user = Table::factory('Users')->newObject();
            }
            $user->setValues(array(
                'username' => $details->screen_name,
                'twitter_id' => $details->id,
                'profile_image_url' => $details->profile_image_url,
                'oauth_token' => $token->oauth_token,
                'oauth_token_secret' => $token->oauth_token_secret,
                'type' => 'account',
                'identifier' => sha1(mt_rand().$token->oauth_token_secret),
            ));
            $user->save();
        } else {
            Log::debug('authenticating known user ['.$details->screen_name.']');
            // as you were
            if ($details->screen_name != $user->username ||
                $details->profile_image_url != $user->profile_image_url ||
                $token->oauth_token != $user->oauth_token ||
                $token->oauth_token_secret != $user->oauth_token_secret) {

                Log::debug('syncing twitter details...');
                $user->updateValues(array(
                    'username' => $details->screen_name,
                    'profile_image_url' => $details->profile_image_url,
                    'oauth_token' => $token->oauth_token,
                    'oauth_token_secret' => $token->oauth_token_secret,
                ));
                $user->save();
            }
        }

        // sets cookies too
        $user->addToSession();
        $this->user = $user;


        $message = "Hi, <strong>".$user->username."</strong>!";

        if ($this->request->getVar('target') !== null) {
            return $this->redirect($this->request->getVar('target'), $message);
        } else {
            return $this->redirect(array(
                "app" => "default",
                "controller" => "Default",
                "action" => "index",
            ), $message);
        }
    }

    public function account() {
        //
    }

    public function update_account() {
        if (!$this->request->isPost()) {
            return $this->redirect("/");
        }

        // @todo figure out validation for awkward one-to-manys like this where validation differs
        // based on key
        // @todo make this more performant too - lots of DB queries to delete then add individually...
        $this->user->clearPreferences();
        $data = array_intersect_key($this->request->getPost(), array('email' => true, 'email_digests' => true));
        foreach ($data as $key => $value) {
            $preference = Table::factory('UserPreferences')->newObject();
            $preference->setValues(array(
                'user_id' => $this->user->getId(),
                'key' => $key,
                'value' => $value,
            ));
            $preference->save();
        }
        return $this->redirectAction("account", "Settings Updated");
    }
}
