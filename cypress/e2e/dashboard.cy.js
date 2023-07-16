function logUserIn(username, password) {
  cy.visit("//localhost/login");
  cy.get("#username").type(username);
  cy.get("#password").type(password);
  cy.get("#login").submit();
}

// Create a new test user
const username = "tester" + Math.floor(Math.random() * 100);
const password = "Password" + Math.floor(Math.random() * 100);

function createUser() {
  cy.visit("//localhost/signup");
  cy.get("#username").type(username);
  cy.get("#password").type(password);
  cy.get("#cPassword").type(password);
  
  cy.get("#submit").click();  
}

describe("Create test user", () => {
  it("Creates a test user", () => {
    createUser();
  })
})

describe("Checks user dashboard", () => {
  it("Ensures username displays in navbar", () => {
    logUserIn(username, password);
    cy.get("#nUsername").should("have.text", username);
  })
})

describe("Writes a new statement", () => {
  it("Writes a new statement", () => {
    logUserIn(username, password);

    // Click to get modal to create a new statement
    cy.get("#nsBtn").click();

    // Write statement title
    cy.get("#nsTitle").type("I like apples");

    // Write statement description
    cy.get("#nsText").type("I think apples are really cool");

    // Submit form
    cy.get("#nsForm").submit();
  })

  it("Ensures statement exists", () => {
    logUserIn(username, password);

    // Find statement title
    cy.get(".statement-title").first().should("have.text", "I like apples");
  })
})

describe("Edits a statement", () => {
  it("Edits a statement", () => {
    logUserIn(username, password);

    // Find statement edit button
    cy.get(".statement-edit").first().click();

    // Clear and change title
    cy.get("#title").clear();
    cy.get("#title").type("I take it back I don't like apples");

    // Submit form
    cy.get("#editStateForm").submit();
  })

  it("Ensures statement has changed", () => {
    logUserIn(username, password);

    // Find statement title
    cy.get(".statement-title").first().should("have.text", "I take it back I don't like apples");
  })
})

describe("Deletes a statement", () => {
  it("Deletes a statement", () => {
    logUserIn(username, password);

    // Find statement delete button
    cy.get(".statement-delete").first().click();
    cy.get(".statement-title").should("not.exist");
  })
})
