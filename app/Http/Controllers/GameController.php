<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tables;
use App\Players;

// define("SPADES", 4);
// define("HEARTS", 3);
// define("DIAMONDS", 2);
// define("CLUBS", 1);

class GameController extends Controller
{
    // const SPADES = 4;
    // const HEARTS = 3;
    // const DIAMONDS = 2;
    // const CLUBS = 1;
    // const JACK = 11;
    // const QUEEN = 12;
    // const KING = 13;
    // const ACE = 14;

    public function storeWinner($id, $tableID)
    {
        $playerData = Players::find($id);
        $tabledata = Tables::find($tableID);
        $playerData->balance += $tabledata->current_value;
        $tabledata->current_value = 0;
        $playerData->save();
        $tabledata->save();
        return $playerData->id;
    }
    public function value($genre)
    {
        switch ($genre) {
            case "SPADES":
                return 4;
                break;
            case "HEARTS":
                return 3;
                break;
            case "DIAMONDS":
                return 2;
                break;
            case "CLUBS":
                return 1;
                break;
            default:
                return 0;
        }
    }

    public function genre_total($first, $second, $third)
    {
        return  $this->value($first) + $this->value($second) + $this->value($third);
    }

    public function pack(Request $request)
    {
        $trail = array();
        $pure_seq = array();
        $seq = array();
        $color = array();
        $pair = array();
        $high_card = array();
        foreach ($request->playerID as $id) {
            $card1 = $request['playerCards'][$id]['card1'];
            $card2 = $request['playerCards'][$id]['card2'];
            $card3 = $request['playerCards'][$id]['card3'];
            $this->calculate($card1, $card2, $card3);
            $res = $this->calculate($card1, $card2, $card3);
            if ($res == 'trail') {
                $trail[] = array('id' => $id, 'high_card' => $card3['value']);
            } else if ($res == 'pure_sequence') {
                $pure_seq[] = array('high_card' => $card3['value'], 'genre' => $this->value($card3['genre']), 'id' => $id);
            } else if ($res == 'sequence') {
                //$genre_total = $this->genre_total($card1['genre'], $card2['genre'], $card3['genre']);
                $seq[] = array('high_card' => $card3['value'], 'genre' => $this->value($card3['genre']), 'id' => $id);
            } else if ($res == 'color') {
                $sum_cards = $card3['value'] + $card2['value'] + $card1['value'];
                $color[] = array('card3' => $card3['value'], 'card2' => $card2['value'], 'card1' => $card1['value'], 'genre' => $this->value($card3['genre']), 'id' => $id);
            } else if ($res == 'high_card') {
                $sum_cards = $card3['value'] + $card2['value'] + $card1['value'];
                $high_card[] = array('card3' => $card3['value'], 'card2' => $card2['value'], 'card1' => $card1['value'], 'genre' => $this->value($card3['genre']), 'id' => $id);
            } else if ($res == 'pair') {
                if ($card3['value'] == $card2['value']) {
                    $pair_value = $card3['value'];
                    $other_card = $card1['value'];
                    $genre = $card1['genre'];
                } else {
                    $pair_value = $card1['value'];
                    $other_card = $card3['value'];
                    $genre = $card3['genre'];
                }
                //$genre_total = $this->genre_total($card1['genre'], $card2['genre'], $card3['genre']);
                $pair[] = array('pair_value' => $pair_value, 'other_card' => $other_card, 'genre' => $this->value($genre), 'id' => $id);
            } else {
                return $res;
            }
        }
        $winner = $this->result($trail, $pure_seq, $seq, $color, $pair, $high_card);
        $round_winner = $this->storeWinner($winner['id'], $request->tableID);
        return $round_winner;
        // return $request->playerID;
    }

    public function calculate($card1, $card2, $card3)
    {
        if ($card1['value'] - $card2['value'] == 0 && $card2['value'] - $card3['value'] == 0) {
            return 'trail';
        } else if ($card3['value'] - $card2['value'] == 1 && $card2['value'] - $card1['value'] == 1) {
            if ($card3['genre'] == $card2['genre'] && $card1['genre'] == $card2['genre']) {
                return 'pure_sequence';
            } else {
                return 'sequence';
            }
        } else if (($card3['value'] - $card2['value'] != 1 || 0) || ($card2['value'] - $card1['value'] != 1 || 0)) {
            if ($card3['genre'] == $card2['genre'] && $card1['genre'] == $card2['genre']) {
                return 'color';
            } else if (($card3['value'] == $card2['value'] && $card2['value'] != $card1['value']) || ($card3['value'] != $card2['value'] && $card2['value'] == $card1['value'])) {
                return 'pair';
            } else {
                return 'high_card';
            }
        } else {
            return "sddg";
        }
    }

    public function result($trail, $pure_seq, $seq, $color, $pair, $high_card)
    {
        //return count($trail);
        if ($trail) {
            if (count($trail) == 1) {
                return ($trail);
            } else {
                $max = max(array_column($trail, 'high_card'));
                $key = array_search($max, array_column($trail, 'high_card'));
                return $trail[$key];
            }
        } else if ($pure_seq) {
            if (count($pure_seq) == 1) {
                return $pure_seq[0];
            } else {
                $max = max($pure_seq);
                return $max;
            }
        } else if ($seq) {
            if (count($seq) == 1) {
                return $seq;
            } else {
                $max = max($seq);
                return $max;
            }
        } else if ($color) {
            if (count($color) == 1) {
                return $color;
            } else {
                $max = max($color);
                return $max;
            }
        } else if ($pair) {
            if (count($pair) == 1) {
                return $pair;
            } else {
                $max = max($pair);
                return $max;
            }
        } else if ($high_card) {
            if (count($high_card) == 1) {
                return $high_card;
            } else {
                $max = max($high_card);
                return $max;
            }
        }
    }
}