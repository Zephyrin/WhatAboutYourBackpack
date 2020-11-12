import { environment } from '@app/../environments/environment';
import { Observable } from 'rxjs';
import { Characteristic } from '@app/_model/equipment';
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

  public addCharacteristic(data: Characteristic): Observable<Characteristic> {
    return this.http.post<Characteristic>(
      `${environment.apiUrl}/${this.createPath()}/${data.equipment.id}/characteristic`, data);
  }

  public updateCharacteristic(characteristic: Characteristic): Observable<Characteristic> {
    return this.http.patch<Characteristic>(
      `${environment.apiUrl}/${this.updatePath()}/${characteristic.equipment.id}/characteristic/${characteristic.id}`,
      characteristic);
  }
}
