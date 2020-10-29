﻿import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject, Observable } from 'rxjs';
import { map, first } from 'rxjs/operators';

import { environment } from '@environments/environment';
import { User } from '@app/_models';

@Injectable({ providedIn: 'root' })
export class AuthenticationService {
  private currentUserSubject: BehaviorSubject<User>;
  public currentUser: Observable<User>;
  constructor(
    private http: HttpClient) {
    this.currentUserSubject = new BehaviorSubject<User>(JSON.parse(localStorage.getItem('currentUser')));
    this.currentUser = this.currentUserSubject.asObservable();
  }

  public get currentUserValue(): User {
    return this.currentUserSubject.value;
  }

  login(username: string, password: string) {
    return this.http.post<any>(
      `${environment.apiUrl}/auth/login_check`, { username, password })
      .pipe(map(token => {
        // store user details and jwt token in local storage to keep user logged in between page refreshes
        return token.token;
      }));
  }

  registerLogin(token: any, username: string) {
    return this.getUser(username, token.token);
  }

  getUser(username: string, token: string) {
    return this.http.get<User>(
      `${environment.apiUrl}/user/${username}`,
      { headers: { Authorization: `Bearer ${token}` } })
      .pipe(first()).pipe(map(user => {
        user.token = token;

        localStorage.setItem('currentUser', JSON.stringify(user));
        this.currentUserSubject.next(user);
        return user;
      }));
  }

  logout() {
    // remove user from local storage to log user out
    localStorage.removeItem('currentUser');
    this.currentUserSubject.next(undefined);
  }

  public signup(user: User) {
    return this.http.post<any>(
      `${environment.apiUrl}/auth/register`, user)
      .pipe(map(token => {
        return token.token;
      }));
  }
}
