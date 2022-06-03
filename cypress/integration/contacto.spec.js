///<references types="cypress"/>

describe ('Prueva la Navegacion y Routing del Header y Footer', () => {
    it('Prueba la Pagina de Contacto y el envio de Email', () =>{
        cy.visit('/contacto');
        cy.get('[data-cy="heading-contacto"]').should('exist');
        cy.get('[data-cy="heading-contacto"]').invoke('text').should('equal','Contacto');
        cy.get('[data-cy="heading-contacto"]').invoke('text').should('not.equal','Formulario de Contacto');

        cy.get('[data-cy="heading-formulario"]').should('exist');
        cy.get('[data-cy="heading-formulario"]').invoke('text').should('equal','Llene el formulario de Contacto');
        cy.get('[data-cy="heading-formulario"]').invoke('text').should('not.equal','Llena Formulario de Contacto');

        cy.get('[data-cy="formulario-contacto"]').should('exist');

    })
    it('Llena los campos del formulario', () =>{
        cy.get('[data-cy="input-nombre"]').type('Diego');
        cy.get('[data-cy="input-mensaje"]').type('Deseo comprar una casa');
        cy.get('[data-cy="input-opciones"]').select('Compra');
        cy.get('[data-cy="input-precio"]').type('12000');
        cy.get('[data-cy="forma-contacto"]').eq(1).check();
        cy.get('[data-cy="input-email"]').type('correo@correo.com');
        cy.wait(3000);
        cy.get('[data-cy="forma-contacto"]').eq(0).check();

        cy.get('[data-cy="input-telefono"]').type('0982456321');
        cy.get('[data-cy="input-fecha"]').type('2022-06-03');
        cy.get('[data-cy="input-hora"]').type('15:51:15');


        cy.get('[data-cy="formulario-contacto"]').submit();
        cy.get('[data-cy="alerta-envio-formulario"]').should('exist');
        cy.get('[data-cy="alerta-envio-formulario"]').invoke('text', 'Mensaje Enviado Correctamente');
        cy.get('[data-cy="alerta-envio-formulario"]').should('have.class','alerta').and('have.class', 'exito');

    });
});