import { domain, createUser, deleteUser, logUserIn } from "../helpers/testUser.js";

let authorUser;
let authorPass;

describe("Accounts setup", () => {
  it("Successfully creates author account", () => {
    const details = createUser();
    authorUser = details[0];
    authorPass = details[1];
  })
})

describe("Create statement", () => {
  it("Successfully creates statement", () => {
    logUserIn(authorUser, authorPass);
    cy.get("#nsBtn").click();
    cy.get("#nsTitle").type("Title");
    cy.get("#nsText").type("Some text");
    cy.get("#nsForm").submit();
  })
})

describe("View full statement", () => {
  it("Successfully views statement from dash", () => {
    logUserIn(authorUser, authorPass);
    cy.get(".statement").first().click();
    cy.get("h1").should("have.text", "Title");
    cy.get("#statementText").should("have.text", "Some text");
  })
})

describe("Edit statement", () => {
  it("Successfully edits a statement", () => {
    logUserIn(authorUser, authorPass);
    cy.get(".statement-edit").first().click();
    
    cy.get("#title").clear();
    cy.get("#title").type("Different title");

    cy.get("#text").clear();
    cy.get("#text").type("Different text");

    cy.get("form").submit();

    cy.get("h1").should("have.text", "Different title");
    cy.get("#statementText").should("have.text", "Different text");
  })
})

describe("Delete account", () => {
   it("Successfully deletes the test account", () => {
    logUserIn(authorUser, authorPass);
   cy.get("#delAcc").click();
   cy.get(".swal2-confirm").click();
   })
})