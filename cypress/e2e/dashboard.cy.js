function logUserIn() {
  cy.visit("//localhost/login");
  cy.get("#username").type("MrElephant");
  cy.get("#password").type("Password1");
  cy.get("#login").submit();
}

describe("Checks user dashboard", () => {
  it("Ensures username displays in navbar", () => {
    logUserIn();
    cy.get("#nUsername").should("have.text", "MrElephant");
  })
})

describe("Writes a new statement", () => {
  it("Writes a new statement", () => {
    logUserIn();

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
    logUserIn();

    // Find statement title
    cy.get(".statement-title").first().should("have.text", "I like apples");
  })
})

describe("Edits a statement", () => {
  it("Edits a statement", () => {
    logUserIn();

    // Find statement edit button
    cy.get(".statement-edit").first().click();

    // Clear and change title
    cy.get("#title").clear();
    cy.get("#title").type("I take it back I don't like apples");

    // Submit form
    cy.get("#editStateForm").submit();
  })

  it("Ensures statement has changed", () => {
    logUserIn();

    // Find statement title
    cy.get(".statement-title").first().should("have.text", "I take it back I don't like apples");
  })
})

describe("Deletes a statement", () => {
  it("Deletes a statement", () => {
    logUserIn();

    // Find statement delete button
    cy.get(".statement-delete").first().click();
    cy.get(".statement-title").should("not.exist");
  })
})
