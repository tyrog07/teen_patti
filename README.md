<h2>Teen Patti Game</h2>
This is Laravel project serving as backend to Teen Patti game. It follows principle of REST API. It also considers BOTS in game. Logic is implemented regarding that.
<h2> Usage </h2>

1) Place bet (POST)<br>
   > Endpoint:/admin/bid
    
  ```
  {
    id: 4, //user id
    currentBet: 100,
    tableID: 4
  }
  ```

> Response : success


2) Add player to table (POST) <br>
    Endpoint:/admin/storePlayerOnTable
    
    ```
   {
     id: 12, //user id
     boot_value: 10,
     pot_limit: 20000
   }
   ```

> Response: 

```
   {
     "id": 13,
     "players_id": "3,9,10,11,12",
     "total_players": 5,
     "created_at": "2020-05-19T05:56:30.000000Z",
     "updated_at": "2020-05-19T06:01:01.000000Z",
     "boot_value": "10",
     "pot_limit": "20000",
     "real_players": 3,
     "current_value": "0"
   }
   ```
 
 
 3) Retrive table details
    Endpoint:/admin/retriveTable
    
   ```
   {
     tableID: 1,
   }
   ```
   
   > Response: 
   
   ```
   {
     "id": 1,
     "players_id": "3,9,10,2,1",
     "total_players": "5",
     "created_at": "2020-05-17T00:00:00.000000Z",
     "updated_at": "2020-05-17T13:53:40.000000Z",
     "boot_value": "10",
     "pot_limit": "1020",
     "real_players": "3",
     "current_value": "1610"
   }
 ```
 
 4) Retrive player details<br>
    Endpoint:/admin/retrivePlayer
    
    ```
    {
     id: 2,
    }
    ```
    
    > Response: 
    ```
    {
     "id": 2,
     "name": "elephant",
     "email": "elephant@gmail.com",
     "balance": "2000",
     "type": "real",
     "table_occupied": "yes",
     "playing": "no",
     "created_at": "2020-05-17T00:00:00.000000Z",
     "updated_at": "2020-05-17T09:06:06.000000Z"
    }
    ```
    
 5) Is Playing Game<br>
    Endpoint:/admin/isPlaying
    
    ```
    {
     id: 8,
     tableID: 9
    }
    ```
    
    > Response: 
    ```
    {
     "id": 8,
     "name": "lizard",
     "email": "lizaed@gmail.com",
     "balance": "2700",
     "type": "player",
     "table_occupied": "no",
     "playing": "yes",
     "created_at": "2020-05-17T00:00:00.000000Z",
     "updated_at": "2020-05-19T06:04:56.000000Z"
    }
    ```
    
 6) Quit Game<br>
    Endpoint:/admin/quitGame
    
    ```
     {
      id: 12,
      tableID: 13
     }
    ```
    
    > Response:
    
    ```
    {
      "id": 13,
      "players_id": "3,9,10,11",
      "total_players": 4,
      "created_at": "2020-05-19T05:56:30.000000Z",
      "updated_at": "2020-05-19T06:07:16.000000Z",
      "boot_value": "10",
      "pot_limit": "20000",
      "real_players": 2,
      "current_value": "0"
    }
    ```

 7) Winner<br>
    Endpoint:/admin/pack
    
    ```
    var playerID = [1, 8, 9];
    var tableID = 2;

    var playerCards = {
     1: {
         card1: {
             genre: 'SPADES',
             value: 2
         },
         card2: {
             genre: 'CLUBS',
             value: 10
         },
         card3: {
             genre: 'SPADES',
             value: 11
         }
     },
     8: {
         card1: {
             genre: 'DIAMONDS',
             value: 7
         },
         card2: {
             genre: 'DIAMONDS',
             value: 8
         },
         card3: {
             genre: 'DIAMONDS',
             value: 9
         }
     },
     9: {
         card1: {
             genre: 'SPADES',
             value: 7
         },
         card2: {
             genre: 'CLUBS',
             value: 11
         },
         card3: {
             genre: 'SPADES',
             value: 12/         
             }
     }
    };
    ```
    
    > Response:
    
    ```
    8 (id of winning player)
    ```
