import React from 'react';
import { useState } from "react";
import ImputPh from "./InputPH";



export default function LoginAndRegister({ handleClick }) {
    const [loginPanelSwitch, setloginPanelSwitch] = useState(false);

    return (
        <div id='pageCover'>
            <div id='loginPanel'>
                <div id='loginToggle' onClick={() => handleClick()}></div>
                <div id='loginContent'>
                    <div className={`loginSide shown ${loginPanelSwitch ? '' : 'active'}`}>
                        <p className='loginTitle'> Iniciar Sesión </p>
                        <form id='loginForm' action="" method="post">
                            <ImputPh props={{type: 'text', id:'usernameL', span:'Nombre de usuario'}}/>
                            <label htmlFor="passwordL">
                                <span> Contraseña </span>
                                <input type="password" id="passwordL" autoComplete="off" />
                                <svg className="eye" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1"
                                    strokeLinecap="round" strokeLinejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="5"></circle>
                                    <line x1="4" y1="4" x2="20" y2="20"></line>
                                </svg>
                            </label> <br />
                            <input type="submit" value="Confirmar" className='button' />
                        </form>
                    </div>
                    <div className={`loginSide hidden ${loginPanelSwitch ? 'active' : ''}`}>
                        <p className='loginSubtitle'>¿Ya tienes una cuenta?</p>
                        <a className='loginButton' onClick={() => setloginPanelSwitch(!loginPanelSwitch)}>Iniciar Sesión</a>
                    </div>
                    <div id='loginSeparator'></div>
                    <div className={`registerSide shown ${loginPanelSwitch ? 'active' : ''}`}>
                        <p className='loginTitle'> Registrarse </p>
                        <form id='registerForm' action="#" method="post">
                            <label htmlFor='usernameR'>
                                <span> Nombre de usuario </span>
                                <input type="text" id="usernameR" autoComplete="off" />
                            </label>
                            <label htmlFor='name'>
                                <span> Nombre </span>
                                <input type="text" id="name" autoComplete="off" />
                            </label>
                            <label htmlFor='lastname'>
                                <span> Apellido </span>
                                <input type="text" id="lastname" autoComplete="off" />
                            </label>
                            <label htmlFor='birthdate'>
                                <span> Fecha de nacimiento </span>
                                <input type="date" id="birthdate" autoComplete="off" />
                            </label>
                            <label htmlFor='email'>
                                <span> Correo electrónico </span>
                                <input type="email" id="email" autoComplete="off" />
                            </label>
                            <label htmlFor='phoneNumber'>
                                <span> Teléfono </span>
                                <input type="number" id="phoneNumber" autoComplete="off" />
                            </label>
                            <label htmlFor='passwordR'>
                                <span> Contraseña </span>
                                <input type="password" id="passwordR" autoComplete="off" />
                                <svg className="eye" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1"
                                    strokeLinecap="round" strokeLinejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="5"></circle>
                                    <line x1="4" y1="4" x2="20" y2="20"></line>
                                </svg>
                            </label>
                            <label htmlFor='passwordConfirm'>
                                <span> Confirmar contraseña </span>
                                <input type="password" id="passwordConfirm" autoComplete="off" />
                            </label><br />
                            <input type="submit" value="Confirmar" className="button" />
                        </form>
                    </div>
                    <div className={`registerSide hidden ${loginPanelSwitch ? '' : 'active'}`}>
                        <p className='loginSubtitle'>¿No tienes una cuenta?</p>
                        <a className='loginButton' onClick={() => setloginPanelSwitch(!loginPanelSwitch)}>¡Regístrate!</a>
                    </div>

                </div>
            </div>
        </div>
    );
}