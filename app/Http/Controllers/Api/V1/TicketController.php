<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Ticket;
use App\Policies\V1\TicketPolicy;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Resources\V1\TicketResource;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TicketController extends ApiController
{
    protected $policyClass = TicketPolicy::class;
    /**
     * Display a listing of the resource.
     */
    public function index(TicketFilter $filters)
    {
        return  TicketResource::collection(Ticket::filter($filters)->paginate());
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {

        $this->isAble('store', Ticket::class);

        return new TicketResource(Ticket::create($request->mappedAttributes()));
    }
    /**
     * Display the specified resource.
     */
    public function show($ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);

        if ($this->include('author')) {
            return  new TicketResource($ticket->load('user'));
        }

        return new TicketResource($ticket);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {

        $ticket = Ticket::findOrFail($ticket->id);

        $this->isAble('update', $ticket);

        $ticket->update($request->mappedAttributes());

        return new TicketResource($ticket);
    }
    /**
     * Replace the specified resource in storage.
     */
    public function replace(ReplaceTicketRequest $request, $ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);

        $this->isAble('replace', $ticket);

        $ticket->update($request->mappedAttributes());

        return new TicketResource($ticket);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ticket_id)
    {
        try {
            $ticket  = Ticket::findOrFail($ticket_id);

            if ($this->isAble('delete', $ticket)) {
                $ticket->delete();

                return $this->ok('Ticket successfully deleted');
            };

            return $this->error('You are not authorized to delete that resource', 403);
        } catch (ModelNotFoundException $ex) {
            return $this->error('Ticket cannot be found.', 404);
        }
    }
}
