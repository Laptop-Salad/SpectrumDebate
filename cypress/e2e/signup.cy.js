describe("Sign Up page", () => {
  it("successfully loads", () => {
    cy.visit("//localhost/signup")
  })
})

// Username for testing purposes
const username = "tester" + Math.floor(Math.random() * 100);

describe("Sign up", () => {
  it("Signs up a new user", () => {
    cy.visit("//localhost/signup");

    // Enter username
    cy.get("#username").type(username);

    // Enter password
    cy.get("#password").type("Password1");

    // Submit form
    cy.get("#signupForm").submit();

    // User is redirected to login
    cy.url().should("eq", "http://localhost/login");
  })

  it("Ensures new user can log in", () => {
    cy.visit("//localhost/login");

    // Enter login details
    cy.get("#username").type(username);
    cy.get("#password").type("Password1");

    // Submits form
    cy.get("#login").submit();

    // If login detais are correct, user should be sent to dashboard
    cy.url().should("eq", "http://localhost/dashboard");
  })

  /* Could be in dashboard tests but is here to prevent too many
  tester accounts. 
  */
  describe("Deletes user", () => {
    it("Deletes new user", () => {
      cy.visit("//localhost/login");

      // Enter login details
      cy.get("#username").type(username);
      cy.get("#password").type("Password1");
  
      // Submits form
      cy.get("#login").submit();
  
      // Click delete account button
      cy.get("#delete").click();  
    })

    it("Ensures new user has been deleted", () => {
      cy.visit("//localhost/login");

      // Enter login details
      cy.get("#username").type(username);
      cy.get("#password").type("Password1");
  
      // Submits form
      cy.get("#login").submit();

      // Should say username/password is incorrect
      cy.get("#showInvalid").should("be.visible");
    })
  })
})