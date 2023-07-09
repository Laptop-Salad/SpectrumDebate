  describe("Login page loads", () => {
  it("Successfully loads", () => {
    cy.visit("//localhost/login")
  })
})

describe("Successful Login", () => {
  it("Logs in user using correct details", () => {
    // Visit login page
    cy.visit("//localhost/login");

    // Enter correct login details
    cy.get("#username").type("MrElephant");
    cy.get("#password").type("Password1");

    // Submits form
    cy.get("#login").submit();

    // If login detais are correct, user should be sent to dashboard
    cy.url().should("eq", "http://localhost/dashboard");
  })
})

describe("Unsuccessful login", () => {
  it("Tries to log in user using incorrect username", () => {
    // Visits login page
    cy.visit("//localhost/login");

    // Enters incorrect username
    cy.get("#username").type("MrEle");
    cy.get("#password").type("Password1");

    // Submits form
    cy.get("#login").submit();

    // Invalid username/password message should be displayed
    cy.get("#showInvalid").should("be.visible");
  })

  it("Tries to log in user using incorrect password", () => {
    // Visits login page
    cy.visit("//localhost/login");

    // Enters incorrect password
    cy.get("#username").type("MrElephant");
    cy.get("#password").type("Helloworld");

    // Submits form
    cy.get("#login").submit();

    // Invalid username/password message should be displayed
    cy.get("#showInvalid").should("be.visible");
  })
})