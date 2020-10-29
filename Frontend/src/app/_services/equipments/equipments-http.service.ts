import { HttpClient } from '@angular/common/http';
import { HttpService } from '@app/_services/http.service';
import { Injectable } from '@angular/core';
import { Equipment } from '@app/_model/equipment';

@Injectable({
  providedIn: 'root'
})
export class EquipmentsHttpService extends HttpService<Equipment> {

  private path = 'equipment';
  private pathAll = 'equipments';

  constructor(protected http: HttpClient) {
    super(http);
  }

  createPath() { return this.path; }

  getAllPath() { return this.pathAll; }

  getPath() { return this.path; }

  updatePath() { return this.path; }

  deletePath() { return this.path; }
}
