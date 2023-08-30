import React, { useEffect } from 'react';

 const InputPh = ({ props }) => {

    useEffect (() => {
        console.log(props.type);
        console.log(props.id);
        console.log(props.span);
     }, [])

     switch (props.type) {
         case 'text':
             return (
                 <>
                     <label htmlFor={props.id}>
                         <span> {props.span} </span>
                         <input type="text" id={props.id} autoComplete="off"/>
                     </label>
                 </>
             );
         case 'password':
             return (
                 <>
                     <label htmlFor={props.id}>
                         <span> {props.span} </span>
                         <input type="password" id={props.id} autoComplete="off"/>
                         <svg className="eye" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1"
                             strokeLinecap="round" strokeLinejoin="round">
                             <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                             <circle cx="12" cy="12" r="5"></circle>
                             <line x1="4" y1="4" x2="20" y2="20"></line>
                         </svg>
                     </label>
                 </>
             );
         case 'passwordNoEye':
             return (
                 <>
                     <label htmlFor={props.id}>
                         <span> {props.span} </span>
                         <input type="password" id={props.id} autoComplete="off"/>
                     </label>
                 </>
             );
        case 'date':
            return(
                <>
                    <label htmlFor={props.id}>
                        <span> {props.span} </span>
                        <input type="date" id={props.id} autoComplete="off" />
                    </label>
                </>
            );
        case 'email':
            return(
                <>
                    <label htmlFor={props.id}>
                        <span> {props.span} </span>
                        <input type="email" id={props.id} autoComplete="off" />
                    </label>
                </>
            );
        case 'number':
                return(
                    <>
                        <label htmlFor={props.id}>
                            <span> {props.span} </span>
                            <input type="number" id={props.id} autoComplete="off" />
                        </label>
                    </>
                );
         default:
             return (
                 console.log("Incorrect Type")

             );
     }

 }

export default InputPh;