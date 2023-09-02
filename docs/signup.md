# Sign Up Process

1. User goes to /signup
2. Signup Controller is instantiated
3. Display sign up page
4. User enters details that are checked in signup.js continuously
5. Details are sent to signup controller
6. Details are checked to see if they are valid
7. If details are valid user is created, if not an error notification is displayed

## Input Validation
"submit" button to signup form is only enabled once certain requirements have been met. These requirements are:

- The username is available and meets length requirements
- The password meets length requirements
- Confirm password matches password

These are checked in signup.js. If these are valid, then the same checks are performed at the backend. If any are invalid in the backend, then the user is not created and a notification is displayed to the user.
