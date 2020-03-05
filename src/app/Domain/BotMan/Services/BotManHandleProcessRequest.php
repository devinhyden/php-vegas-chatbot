<?php

namespace App\Domain\BotMan\Services;

use App\Domain\BotMan\Conversations\StartConversation;
use App\Domain\BotMan\Conversations\SupportConversation;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Slack\SlackDriver;

class BotManHandleProcessRequest
{
    /**
     * @var Question
     */
    private $help;

    public function __construct()
    {
        $this->help = Question::create("Sorry, I did not understand these commands. Here is a list of commands I understand")
            ->fallback('Unable to ask question')
            ->callbackId('unknown_command')
            ->addButtons([
                Button::create('Hello')->value('hello'),
                Button::create('The Best User Group?')->value('bestusergroup'),
                Button::create('Conversation')->value('conversation'),
                Button::create('Support')->value('support'),
                Button::create('Help')->value('help'),
            ]);
    }

    /**
     * Execute Botman and Process Request
     */
    public function run()
    {
        DriverManager::loadDriver(SlackDriver::class);
        $botman = BotManFactory::create(config('botman'), new LaravelCache());

        $botman->hears('.*hello', function (BotMan $bot) {
            $bot->reply('Hello there.');
        });

        $botman->hears('call me {name}', function ($bot, $name) {
            $bot->reply('Your name is: '.$name);
        });

        $botman->hears('.*bestusergroup', function (BotMan $bot) {
            $bot->reply('I know....PHP Vegas is awesome!');
        });

        $botman->hears('.*conversation', function (Botman $bot) {
            $bot->startConversation(new StartConversation());
        });

        $botman->hears('support', function (Botman $bot) {
            $bot->startConversation(new SupportConversation());
        });

        /* $dialogflow = DialogflowV2::create()->listenForAction();

         // Apply global "received" middleware
         $botman->middleware->received($dialogflow);

         // Apply matching middleware per hears command
         $botman->hears('weather', function (BotMan $bot) {
             // The incoming message matched the "my_api_action" on Dialogflow
             // Retrieve Dialogflow information:
             $extras = $bot->getMessage()->getExtras();
             $apiReply = $extras['apiReply'];
             $apiAction = $extras['apiAction'];
             $apiIntent = $extras['apiIntent'];

             $bot->reply("this is my reply");
             $bot->reply($apiReply);
             $bot->reply($apiAction);
             $bot->reply($apiIntent);

         })->middleware($dialogflow);*/

        $botman->hears('help', function (Botman $bot) {
            $bot->reply($this->help);
        });

        $botman->fallback(function ($bot) {
            $bot->reply($this->help);
        });

        $botman->listen();
    }

}
