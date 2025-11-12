import 'package:dartz/dartz.dart';
import 'package:injectable/injectable.dart';

import '../../../../core/error/exceptions.dart';
import '../../../../core/error/failures.dart';
import '../../domain/entities/counter.dart';
import '../../domain/repositories/counter_repository.dart';
import '../datasources/counter_local_data_source.dart';
import '../models/counter_model.dart';

@Injectable(as: CounterRepository)
class CounterRepositoryImpl implements CounterRepository {
  final CounterLocalDataSource localDataSource;

  CounterRepositoryImpl(this.localDataSource);

  @override
  Future<Either<Failure, Counter>> getCounter() async {
    try {
      final counter = await localDataSource.getCounter();
      return Right(counter);
    } on CacheException catch (e) {
      return Left(CacheFailure(e.message));
    } catch (e) {
      return Left(UnexpectedFailure(e.toString()));
    }
  }

  @override
  Future<Either<Failure, Counter>> incrementCounter() async {
    try {
      final currentCounter = await localDataSource.getCounter();
      final newCounter = CounterModel(value: currentCounter.value + 1);
      await localDataSource.saveCounter(newCounter);
      return Right(newCounter);
    } on CacheException catch (e) {
      return Left(CacheFailure(e.message));
    } catch (e) {
      return Left(UnexpectedFailure(e.toString()));
    }
  }

  @override
  Future<Either<Failure, Counter>> decrementCounter() async {
    try {
      final currentCounter = await localDataSource.getCounter();
      final newCounter = CounterModel(value: currentCounter.value - 1);
      await localDataSource.saveCounter(newCounter);
      return Right(newCounter);
    } on CacheException catch (e) {
      return Left(CacheFailure(e.message));
    } catch (e) {
      return Left(UnexpectedFailure(e.toString()));
    }
  }

  @override
  Future<Either<Failure, Counter>> resetCounter() async {
    try {
      const newCounter = CounterModel(value: 0);
      await localDataSource.saveCounter(newCounter);
      return const Right(newCounter);
    } on CacheException catch (e) {
      return Left(CacheFailure(e.message));
    } catch (e) {
      return Left(UnexpectedFailure(e.toString()));
    }
  }

  @override
  Future<Either<Failure, void>> saveCounter(Counter counter) async {
    try {
      final model = CounterModel.fromEntity(counter);
      await localDataSource.saveCounter(model);
      return const Right(null);
    } on CacheException catch (e) {
      return Left(CacheFailure(e.message));
    } catch (e) {
      return Left(UnexpectedFailure(e.toString()));
    }
  }
}
