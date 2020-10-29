import { TestBed } from '@angular/core/testing';

import { EquipmentsHttpService } from './equipments-http.service';

describe('EquipmentsHttpService', () => {
  let service: EquipmentsHttpService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(EquipmentsHttpService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
