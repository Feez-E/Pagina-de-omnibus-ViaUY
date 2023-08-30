import React from 'react';
import LoginAndRegister from './LoginAndRegister'
import { useState } from "react";


export default function NavBar() {
    const [menuActive, setMenuActive] = useState(false);
    const [panelActive, setPanelActive] = useState(false);

    function handleClick() {
        // 👇️ take the parameter passed from LoginAndRegister component
        setPanelActive(!panelActive);
        console.log('LoginToggle clicked ');
    }

    return (
        <>
                <header>

                    <nav className={panelActive ? 'active' : ''}>
                        <h1><a href='index.php'><img src='src/img/Logo.png' className='logo' /></a></h1>
                        <a className='userName button' onClick={() => setPanelActive(!panelActive)}>
                            <p>iniciar Sesion</p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round"
                                strokeLinejoin="round" className="feather feather-user">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </a>
                        <LoginAndRegister handleClick={handleClick} />
                    </nav>

                    <div className={`menu ${menuActive ? 'active' : ''}`}>
                        <div className='menuToggle' onClick={() => setMenuActive(!menuActive)}/>
                        <ul className='menuOpt'>
                            <li><a href='#' className='opt'> horarios de salida</a></li>
                            <li><a href='#' className='opt'> mis reservas</a></li>
                            <li><a href='#' className='opt'> opt3</a></li>
                            <li><a href='#' className='opt'> opt4</a></li>
                        </ul>
                        <ul id='userOpt' className='menuOpt'>
                            <li> <a href='#' className='opt'> Ajustes de cuenta</a></li>
                            <li> <a href='#' className='opt'> Cerrar Sesion</a></li>
                        </ul>
                    </div>
                </header>
        </>
    );
}