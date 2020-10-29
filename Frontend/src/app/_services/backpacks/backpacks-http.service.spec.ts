import { TestBed } from '@angular/core/testing';

import { BackpacksHttpService } from './backpacks-http.service';

describe('BackpacksHttpService', () => {
  let service: BackpacksHttpService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(BackpacksHttpService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
