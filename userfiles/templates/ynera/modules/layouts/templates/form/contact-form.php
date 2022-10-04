<?php

/*

type: layout
name: Contact Form
position: 24
description: Contact Form

*/


?>


<div class="contact-wrapper section-padding">
            <div class="container">
                <form class="contact-form">
                    <div class="form-fields">
                        <div class="single-field">
                            <label for="name"> Name <span class="star">*</span> </label>
                            <input type="text" placeholder="Ihr Vorname..." />
                        </div>
                        <div class="single-field">
                            <label for="Name"> <span class="star"></span> </label>
                            <input type="text" placeholder="Ihr Nachname..." />
                        </div>
                    </div>
                    <div class="form-fields">
                        <div class="single-field">
                            <label for="email"> E-Mail Adresse <span class="star">*</span> </label>
                            <input id="email" type="email" placeholder="Ihre E-Mail Adresse..." />
                        </div>
                        <div class="single-field">
                            <label for="telefon"> Telefon <span class="star">*</span> </label>
                            <input id="telefon" type="text" placeholder="Ihre Telefonnummer..." />
                        </div>
                    </div>
                    <div class="form-fields">
                        <div class="single-field text-box">
                            <label for="message"> Nachricht <span class="star">*</span> </label>
                            <textarea
                                id="message"
                                name="message"
                                placeholder="Bitte tragen Sie hier Ihre Nachricht ein..."
                            ></textarea>
                        </div>
                    </div>

                    <div class="form-check-wrapper">
                        <label for="email"> Nachricht <span class="star">*</span> </label>
                        <div class="form-check">
                            <input type="checkbox" id="privacy" />
                            <label for="privacy">
                                Hiermit akzeptiere ich die
                                <a href="#" class="privacy-link">Datenschutzbestimmungen</a>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="button button-primary">
                        Anfrage abschicken
                        <span class="icon">
                            <i class="fas fa-long-arrow-right"></i>
                        </span>
                    </button>
                </form>
            </div>
        </div>
