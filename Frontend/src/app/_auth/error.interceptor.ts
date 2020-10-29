import { Router } from '@angular/router';
import { Injectable } from '@angular/core';
import { HttpRequest, HttpHandler, HttpEvent, HttpInterceptor } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

import { AuthenticationService } from '@app/_services';
import { environment } from '@environments/environment';

@Injectable()
export class ErrorInterceptor implements HttpInterceptor {
  constructor(
    private authenticationService: AuthenticationService,
    private router: Router) { }

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(request).pipe(catchError(err => {
      if (err.status === 401) {
        //if (err.url === `${environment.apiUrl}/viewtranslate`) {
        // auto logout if 401 response returned from api
        //this.authenticationService.logout();
        // this.router.navigate(['/signin']);
        //}
        if (err.url !== `${environment.apiUrl}/auth/login_check`) {
          this.authenticationService.logout();
          this.router.navigate(['/signin']);
          //location.reload();
        }
      }
      return throwError(err);
    }));
  }
}
