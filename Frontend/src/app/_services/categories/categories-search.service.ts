import { Params } from '@angular/router';
import { HttpParams } from '@angular/common/http';
import { Subject } from 'rxjs';
import { ISearch } from './../isearch';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class CategoriesSearchService implements ISearch {
  changePageSubject = new Subject<boolean>();

  constructor() { }

  initSearchParams(httpParams: HttpParams): HttpParams {
    if (httpParams == null) { httpParams = new HttpParams(); }
    httpParams = httpParams.append(
      'parentIsNull', 'true'
    );
    return httpParams;
  }

  setParametersFromUrl(params: Params): void {

  }
}
