#API documentation

##Authenticate user
Returns json data about a single user.
* URL:

  `/api/authenticate`
* Method:
  
  `POST`
* Data Params:

  `email`, 
  
  `password`
  
* Success Response:
  * Code: 200
  * Content: `{"token": "value"}`
  
* Error Response
  * Code: 401 Unauthorized
  * Content: `{"error":"User credentials are not correct!"}`
  
  OR
  
  * Code: 500
  * Content: `{"error":"Something went wrong!"}`



##Logout user
Returns json success message.
* URL:

  `/api/logout`
* Method:
  
  `POST`
* Data Params: none

* Headers:
  * Authorization: `Bearer <token>`
  
* Success Response:
  * Code: 200
  * Content: `{"success": "User is logged off."}`
  
* Error Response
  * Code: 401 Unauthorized
  * Content: `{"error":"Can't logout from server!"}`
  
  OR
  
  * Code: 500
  * Content: `{"error":"Something went wrong!"}`

