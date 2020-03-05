<?php


namespace App\Domain\BotMan\Conversations;


use App\Ticket;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Foundation\Inspiring;

class SupportConversation extends Conversation
{

    /**
     * @var int
     */
    protected $ticketLookupCount = 0;

    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $summary;

    /**
     * @var Ticket
     */
    protected $ticket;

    public function stopsConversation(IncomingMessage $message)
    {
        if ($message->getText() == 'stop') {
            return true;
        }

        return false;
    }

    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create("Unfortunate to hear you are experiencing problems. Have you rebooted your computer? Enter stop at anytime to quit.")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('Yes')->value('yes'),
                Button::create('No')->value('no'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'yes') {
                    $this->say('You should reboot two more times');
                    $this->askNeedSupportTicket();
                } else {
                    $this->say('Reboot and reach back if that does not fix the problem');
                }
            }
        });
    }

    public function askNeedSupportTicket()
    {
        $question = Question::create("Do you need support?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_create_support_ticket')
            ->addButtons([
                Button::create('Yes')->value('yes'),
                Button::create('No')->value('no'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'yes') {
                    $this->askNewOrExistingTicket();
                } else {
                    $this->say('Reboot and reach back if that does not fix the problem');
                }
            }
        });
    }

    public function askNewOrExistingTicket()
    {
        $question = Question::create("Is there an existing ticket for this issue?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_create_support_ticket')
            ->addButtons([
                Button::create('Yes')->value('yes'),
                Button::create('No')->value('no'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'yes') {
                    $this->askExistingTicketReference();
                } else {
                    $this->askName();
                }
            }
        });
    }

    public function askName()
    {
        $this->ask('Hello! What is your name?', function(Answer $answer) {
            $this->name = $answer->getText();
            $this->askEmail();
        });
    }

    public function askEmail()
    {
        $this->ask("{$this->name}, What is your email address?", function(Answer $answer) {
            $this->email = $answer->getText();
            $this->say("Thank you, {$this->name}.");
            $this->askSupportSummary();
        });
    }

    public function askSupportSummary()
    {
        $this->ask("Please explain your problem", function(Answer $answer) {
            $this->summary = $answer->getText();

            $ticket = Ticket::create([
                'name' => $this->name,
                'email' => $this->email,
                'summary' => $this->summary,
                'status' => 'New'
            ]);

            $this->say("Your support ticket has been created. <a target='_blank' href='/ticket/{$ticket->id}'>Reference - {$ticket->id}.</a>");
        });
    }

    public function askExistingTicketReference()
    {
        ++$this->ticketLookupCount;
        $this->say("Ticket Count {$this->ticketLookupCount}");
        if ($this->ticketLookupCount > 3) {
            $question = Question::create("Too many invalid ticket lookup detected. Create new ticket?")
                ->fallback('Unable to ask question')
                ->callbackId('ask_too_many_invalid_ticket_searches_detected')
                ->addButtons([
                    Button::create('Yes')->value('yes'),
                    Button::create('No')->value('no'),
                ]);

            return $this->ask($question, function (Answer $answer) {
                if ($answer->isInteractiveMessageReply()) {
                    if ($answer->getValue() === 'no') {
                        $this->say('I say good day, sir!');
                    } else {
                        $this->say('Starting new ticket process.');
                        $this->askName();
                    }
                }
            });
        }
        return $this->ask('What is the ticket number?', function (Answer $response) {

            $this->ticket = Ticket::find($response->getText());
            if (! $this->ticket) {
                $this->askCannotFindExistingTicketCreateNewTicket($response->getText());
            } else {
                $this->say("Your ticket was created {$this->ticket->created_at->diffForHumans()} and is in the {$this->ticket->status} status.");
                $this->askForTicketUpdate();
            }
        });
    }

    public function askForTicketUpdate()
    {
        $question = Question::create("Would you like to provide an update for the ticket?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_would_you_like_to_provide_an_update_for_the_ticket')
            ->addButtons([
                Button::create('Yes')->value('yes'),
                Button::create('No')->value('no'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'yes') {
                    $this->ask("What is your update", function(Answer $answer) {
                        $this->ticket->summary .= " {$answer->getText()}";
                        $this->ticket->save();
                        $this->say("Your support ticket has been updated. <a target='_blank' href='/ticket/{$this->ticket->id}'>Reference - {$this->ticket->id}</a> A support representative will address your ticket as soon as possible");
                    });
                } else {
                    $this->say('Thank you. A support representative will address your ticket as soon as possible');
            }
            }
        });
    }

    public function askCannotFindExistingTicketCreateNewTicket($ticket)
    {
        $question = Question::create("Could not find ticket {$ticket}. Would you like to enter another ticket number?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_cannot_find_existing_ticket_create_new_ticket')
            ->addButtons([
                Button::create('Yes')->value('yes'),
                Button::create('No')->value('no'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'yes') {
                    $this->askExistingTicketReference();
                } else {
                    $this->say('Starting new ticket process.');
                    $this->askName();
                }
            }
        });
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
