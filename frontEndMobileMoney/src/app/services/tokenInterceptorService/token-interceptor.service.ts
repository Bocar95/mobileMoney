import { Storage } from '@ionic/storage';
import { Observable } from 'rxjs';
import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest, HTTP_INTERCEPTORS } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class TokenInterceptorService implements HttpInterceptor {

  constructor(private storage : Storage) { }

  intercept(req:HttpRequest<unknown>, next:HttpHandler) : Observable<HttpEvent<unknown>> {
    const token = localStorage.getItem('token');
 
    if (token) {
       req = req.clone(
        {
          headers: req.headers.set('Authorization', 'bearer ' + token)
        }
      )
    }
    return next.handle(req);
  }


  // intercept(req, next) {
  //   let authService = this.injector.get(AuthService)
  //   let tokenizedReq = req.clone(
  //     {
  //       headers: req.headers.set('Authorization', 'bearer ' + authService.getToken())
  //     }
  //   )
  //   return next.handle(tokenizedReq);
  // }

}

// export const TokenInterceptorProvider = {
//   provide: HTTP_INTERCEPTORS,
//   useClass: TokenInterceptorService,
//   multi: true
// }
