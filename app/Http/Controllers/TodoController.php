<?php

namespace App\Http\Controllers;

use App\todo;
use App\Tables;
use App\Players;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePlayerOnTable(Request $request)
    {
        $playerData = Players::find($request->id);
        $tableData = Tables::where('total_players', '<', 5)->first();
        if ($playerData->table_occupied == 'yes') {
            return "already_on_table";
        } else {
            if ($tableData) {
                if ($playerData->balance < $tableData->boot_value) {
                    return "not_enough_balance";
                }

                $ids = $tableData->players_id;
                if ($ids == null) {
                    $tableData->players_id = $request->id;
                } else {
                    $up_ids = explode(',', $ids);
                    array_push($up_ids, $request->id);
                    $new_ids = implode(',', $up_ids);
                    $tableData->players_id = $new_ids;
                }
                $tableData->total_players += 1;
                $tableData->real_players += 1;
                $tableData->save();
                return $tableData;
            } else {
                if ($playerData->balance < $request->boot_value) {
                    return "not_enough_balance";
                } else {
                    // $bots = Players::select('id')->where('type', '=', 'bot')->get();
                    $playersArray = [3, 9, 10, $request->id];
                    $players = implode(',', $playersArray);
                    $user = Tables::create(['players_id' => $players, 'total_players' => 4, 'boot_value' => $request->boot_value, 'pot_limit' => $request->pot_limit, 'real_players' => 1]);
                }
            }
            $playerData->table_occupied = 'yes';
            $playerData->save();
        }
        return $user->id;
    }

    public function bid(Request $request)
    {

        $playerData = Players::find($request->id);
        if ($playerData->type != 'bot') {
            if ($request->currentBet > $playerData->balance) {
                return "not_enough_balance";
            } else {
                $playerData->balance = $playerData->balance - $request->currentBet;
                $playerData->save();
            }
        }

        $tableData = Tables::find($request->tableID);
        $tableData->current_value += $request->currentBet;
        $tableData->save();
        if ($tableData->current_value > $tableData->pot_limit) {
            return "pot_limit_exceeded";
        }

        return "success";
    }

    public function retriveTable(Request $request)
    {
        $tableDetails = Tables::find($request->tableID);
        return $tableDetails;
    }

    public function retrivePlayer(Request $request)
    {
        $playerDetails = Players::find($request->id);
        return $playerDetails;
    }

    public function quitGame(Request $request)
    {
        $tableDetails = Tables::find($request->tableID);
        $players = explode(',', $tableDetails->players_id);
        $newPlayers = array_diff($players, [$request->id]);
        $arraysAreEqual = ($players == $newPlayers);
        if (!$arraysAreEqual) {
            $updatedPlayers = implode(',', $newPlayers);
            $tableDetails->players_id = $updatedPlayers;
            $tableDetails->total_players -= 1;
            $tableDetails->real_players -= 1;
            $tableDetails->save();
            if ($tableDetails->real_players == 0) {
                Tables::destroy($request->tableID);
            }

            $playerDetails = Players::find($request->id);
            $playerDetails->table_occupied = "no";
            $playerDetails->save();
        }


        return $tableDetails;
    }

    public function isPlaying(Request $request)
    {
        $playerDetails = Players::find($request->id);
        if ($playerDetails->playing == 'no') {
            $playerDetails->playing = "yes";
        } else {
            $playerDetails->playing = "no";
        }
        $playerDetails->save();
        return $playerDetails;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, todo $todo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(todo $todo)
    {
        //
    }

    public function test(Request $request)
    {
        $bots = Players::select('id')->where('type', '=', 'bot')->get();
        // $playerArray = implode(',', $bots);
        return $request['player1']['card2'];
    }

    public function addOnTable(Request $request)
    {
        return "Sddsfs";
    }
}