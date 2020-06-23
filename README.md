<h2>Teen Patti Game</h2>
This is Laravel project serving as backend to Teen Patti game. It follows principle of REST API. It also considers BOTS in game. Logic is implemented regarding that.
<h2> Usage </h2>
```
1) Place bet (POST)<br>
    Endpoint:/admin/bid
  
  {
    id: 4, //user id
    currentBet: 100,
    tableID: 4
  }
  

Response-> success

2) Add player to table (POST)
    Endpoint:/admin/storePlayerOnTable
   {
     id: 12, //user id
     boot_value: 10,
     pot_limit: 20000
   }

Response-> 
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
 
 3) Retrive table details
    Endpoint:/admin/retriveTable
   {
     tableID: 1,
   }
   Response-> 
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
 
