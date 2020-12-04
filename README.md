<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>



## Expense API

Expense API is a web application provides CRUD operations for expense management. 
E.g. list, create, read, update and delete expenses:

- REST and JSON-RPC API.
- All endpoint expects valid API-KEY token in the header.
Valid test API keys:
- Both for REST and JSON-RPC requests.
  - 0c54b224-094c-4196-badd-1766982cb74b
  - 3146ca98-9364-4e40-a59b-3d8153feef24
- REST only:
  - b5eb7312-aca4-4b36-a827-bfb759da6fe7
  - cfc5b3a8-aec2-4b47-96b3-9ce78c9a768d
- JSON-RPC only:
  - 772cbf4e-b496-4b41-b9a7-c453dda6ab55
  - e4181d14-ea74-4f58-9ae5-3cdc70ab9c0d

#### REST 

Endpoints: [prefixed by /api]
- GET 'expenses/{deletes?}' - List all Expenses from DB.
  - {deletes} is optional. Uses SoftDeletes and if is defined (accepts any string) will return the deleted entries too.
  - https://dmg.code4.digital/api/expenses 
  - https://dmg.code4.digital/api/expenses/deletes
- GET 'expense/{id}' - Returns one Expense or empty array [] defined by 'id'
  - 'id' must be MondoDB ID format.
  - https://dmg.code4.digital/api/expense/5fc93942cc2f3d1da708fe94
- PUT 'expense' -  Create nem Expense entry.
  - Returns Array containing the new created entry ID.
  - https://dmg.code4.digital/api/expense
  - {
        "description": "Description is updated 2", // Must be string.
        "value": 33.33, // Must be numeric.
        "info": "Updating Info and Value" // Must be string if provided.
    }
  - "info" is optional.
- PATCH 'expense/{id}' - Updates an existing Expense record with the new data.
  - 'description', 'value', 'info'. Any value is optional.
  - https://dmg.code4.digital/api/expense/5fc93942cc2f3d1da708fe94
  - {
        "description": "Description is updated 2", // Must be string.
        "value": 33.33, // Must be numeric.
        "info": "Updating Info and Value" // Must be string if provided.
    }
  - {
        "description": "Description is updated 2", // Must be string.
    }
  - {
        "description": "Description is updated 2", // Must be string.
        "value": 33.33, // Must be numeric.
    }
  - {
        "value": 33.33, // Must be numeric.
    }
  - {
        "info": "Updating Info and Value" // Must be string if provided.
    }
- DELETE 'expense/{id} - Deletes one Expense entry defined by 'id'.
  - Returns Array containing the status of the deletion.
  - https://dmg.code4.digital/api/expense/5fc93942cc2f3d1da708fe94

#### JSON-API 

Endpoints: [prefixed by /prc]
- All Requests are sent to: https://dmg.code4.digital/rpc
- Accepts only POST requests.
- Available functions:
  - 'getExpenses' - List all Expenses from DB.
    - 
  - 'getExpense' - Returns one Expense or empty array [] defined by 'id'
    - {
        "_id": "5fc938e871d59f266b6ba2d2"
      }
  - 'addExpense' - Create nem Expense entry.
    - {
        "_id": "5fc938e871d59f266b6ba2d2",
        "description": "Description is updated 2",
        "value": 33.33,
        "info": "Updating Info and Value"
      }
  - 'deleteExpense' - Deletes one Expense entry defined by 'id'.
    - {
        "_id": "5fc938e871d59f266b6ba2d2"
      }
  - 'updateExpense' - Updates an existing Expense record with the new data.
    - {
        "_id": "5fc938e871d59f266b6ba2d2",
        "description": "Description is updated 2",
        "value": 33.33,
        "info": "Updating Info and Value"
      }
      
- JSON-RPC Envelope:
 - {
       "jsonrpc": "2.0",
       "method": "methodName",
       "id": "uniqIdOfTheRequest",
       "params": {
           "key":"value"
       }
   }

TODO:
 - Add Unit and Integration (Behat) tests.
