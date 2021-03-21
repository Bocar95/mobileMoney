import { Storage } from '@ionic/storage';
import { from, Observable, throwError } from 'rxjs';
import { HttpErrorResponse, HttpEvent, HttpHandler, HttpInterceptor, HttpRequest, HttpResponse, HTTP_INTERCEPTORS } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { AlertController } from '@ionic/angular';
import { catchError, map, mergeMap, switchMap } from 'rxjs/operators';
import { AuthService } from '../authService/auth.service';

const TOKEN_KEY = 'auth-token';

@Injectable({
  providedIn: 'root'
})
export class TokenInterceptorService implements HttpInterceptor {

  protected debug = true;

  constructor(private storage : Storage, private alertController: AlertController, private authService : AuthService) { }

  intercept(req:HttpRequest<unknown>, next:HttpHandler) : Observable<HttpEvent<unknown>> {
    
    return from(this.storage.get('token')).pipe(mergeMap(token=>{
      if (token) {
            req = req.clone(
             {
               headers: req.headers.set('Authorization', 'bearer ' + token)
             }
           )
         }
         return next.handle(req);
    }));

  }

  // intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {

  //   const token = localStorage.get('token').then((
  //     val )  => {
  //       if (val) {
  //         request = request.clone({ headers: request.headers.set('Authorization', 'Bearer ' + val) }); 
  //       }
  //     }
  //   );
  //   return next.handle(request);
  // }

  // intercept(req:HttpRequest<unknown>, next:HttpHandler) : Observable<HttpEvent<unknown>> {
  //   const token = localStorage.getItem('token');
 
  //   if (token) {
  //      req = req.clone(
  //       {
  //         headers: req.headers.set('Authorization', 'bearer ' + token)
  //       }
  //     )
  //   }
  //   return next.handle(req);
  // }

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
