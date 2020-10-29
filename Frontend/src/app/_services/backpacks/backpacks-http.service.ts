import { HttpClient } from '@angular/common/http';
import { Backpack } from '@app/_model/backpack';
import { HttpService } from '@app/_services/http.service';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class BackpacksHttpService extends HttpService<Backpack> {

  private path = 'user/{user_id}/backpack';
  private pathAll = 'user/{user_id}/backpacks';

  constructor(protected http: HttpClient) {
    super(http);
  }

  createPath() { return this.path; }

  getAllPath() { return this.pathAll; }

  getPath() { return this.path; }

  updatePath() { return this.path; }

  deletePath() { return this.path; }
}
