import { HttpClient } from '@angular/common/http';
import { HttpService } from '@app/_services/http.service';
import { Injectable } from '@angular/core';
import { Brand } from '@app/_model/brand';

@Injectable({
  providedIn: 'root'
})
export class BrandsHttpService extends HttpService<Brand> {

  private path = 'brand';
  private pathAll = 'brands';

  constructor(protected http: HttpClient) {
    super(http);
  }

  createPath() { return this.path; }

  getAllPath() { return this.pathAll; }

  getPath() { return this.path; }

  updatePath() { return this.path; }

  deletePath() { return this.path; }
}
