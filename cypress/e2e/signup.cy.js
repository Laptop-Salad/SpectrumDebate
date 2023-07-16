function login(username, password) {
  cy.get("#username").type(username);
  cy.get("#password").type(password);
  cy.get("#login").submit();
}

// Username for testing purposes
const username = "tester" + Math.floor(Math.random() * 100);
const password = "Password" + Math.floor(Math.random() * 100);

// ** Load Sign Up Page **
describe("Sign Up page", () => {
  it("successfully loads", () => {
    cy.visit("//localhost/signup")
  })
})

// ** Sign Up a User **
describe("Sign up", () => {
  it("Signs up a new user", () => {
    cy.visit("//localhost/signup");

    cy.get("#submit").should("be.disabled");

    cy.get("#username").type(username);
    cy.get("#userAvail").should("have.text", "Username available");
    cy.get("#userLength").should("have.text", "Between 3 and 10 characters ✓");

    cy.get("#password").type(password);
    cy.get("#passLength").should("have.text", "Between 8 and 20 characters ✓");

    cy.get("#cPassword").type(password);
    cy.get("#passMatch").should("have.text", "Passwords Match");

    cy.get("#submit").should("not.be.disabled");

    // Submit form
    cy.get("#submit").click();

    // User is redirected to login
    cy.url().should("eq", "http://localhost/login/signup");

    // Success notification
    cy.get("body").should("have.attr", "class").and("contain", "swal2-shown")
  })

  it("Ensures new user can log in", () => {
    cy.visit("//localhost/login");

    login(username, password);

    // If login detais are correct, user should be sent to dashboard
    cy.url().should("eq", "http://localhost/dashboard");
  })
})

describe("Taken username", () => {
  it("Stops taken username", () => {
    cy.visit("//localhost/signup")
    cy.get("#username").type(username);
    cy.get("#userAvail").should("have.text", "Username taken");
  })
})

describe("Not matching passwords", () => {
  it("Stops not matching passwords", () => {
    cy.visit("//localhost/signup")
    cy.get("#password").type("Secret007");
    cy.get("#cPassword").type("Secret");
    cy.get("#passMatch").should("have.text", "Passwords don't match");
  })
})

// ** Delete A User **
describe("Deletes user", () => {
  it("Deletes new user", () => {
    cy.visit("//localhost/login");
    
    login(username, password);
    
    // Click delete account button
    cy.get("#delete").click();  
  })

  it("Ensures new user has been deleted", () => {
    cy.visit("//localhost/login");

    login(username, password);

    // Should say username/password is incorrect
    cy.get("#showInvalid").should("be.visible");
  })
})
