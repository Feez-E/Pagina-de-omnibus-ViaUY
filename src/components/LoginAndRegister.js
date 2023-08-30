import React from 'react';
import { useState } from "react";
import InputPh from './InputPh';


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
                            <InputPh props={{type: 'text', id:'usernameL', span:'Nombre de usuario'}}/>
                            <InputPh props={{type: 'password', id:'passwordL', span:'Contraseña'}}/><br/>
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
                            <InputPh props={{type: 'text', id:'usernameR', span:'Nombre de usuario'}}/>
                            <InputPh props={{type: 'text', id:'name', span:'Nombre'}}/>
                            <InputPh props={{type: 'text', id:'lastname', span:'Apellido'}}/>
                            <InputPh props={{type: 'date', id:'birthdate', span:'Fecha de nacimiento'}}/>
                            <InputPh props={{type: 'email', id:'email', span:'Correo electróncio'}}/>
                            <InputPh props={{type: 'number', id:'phoneNumber', span:'Teléfono'}}/>
                            <InputPh props={{type: 'password', id:'passwordR', span:'Contraseña'}}/>
                            <InputPh props={{type: 'passwordNoEye', id:'passwordConfirm', span:'Confirmar contraseña'}}/><br/>
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