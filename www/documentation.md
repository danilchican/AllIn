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


